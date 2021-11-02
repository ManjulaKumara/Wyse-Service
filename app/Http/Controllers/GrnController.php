<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Item;
use App\Models\GrnHeader;
use App\Models\GrnDetails;
use App\Models\ItemStock;
use App\Models\FreeIssue;
use App\Models\GrnDetail;
use App\Models\ItemTransaction;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;


class GrnController extends Controller
{
    public function code_Create() {
        $max_code=DB::select("select grn_code  from grn_header  ORDER BY RIGHT(grn_code , 10) DESC");
        $Regi=null;
        if(sizeof($max_code)==0) {
            $new_code=0;
        } else {
            $last_code_no=$max_code[0]->grn_code;
            list($Regi,$new_code) = explode('-', $last_code_no);
        }
        $new_code='GRN'.'-'.sprintf('%010d', intval($new_code) + 1);
        return $new_code;
    }

    public function create(){
        $grn_code=$this->code_Create();
        view()->share('grn_code',$grn_code);
        $suppliers=Supplier::get();
        view()->share('suppliers',$suppliers);
        $items=Item::where('is_active',1)->get();
        view()->share('items',$items);
        $today=new DateTime();
        $today=$today->format('d/m/Y');
        view()->share('today',$today);
        return view('pages.grn.grn');
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $header_data=[
                'grn_code'=>$this->code_Create(),
                'date'=>$request->grn_date,
                'supplier'=>$request->supplier,
                'receipt_no'=>$request->receipt_no,
                'cashier'=>Auth::user()->id,
                'amount'=>$request->net_total,
                'balance'=>$request->net_total,
                'paid_amount'=>0.00,
                'remarks'=>$request->notes,
                'return_amount'=>0.00,
            ];
            $header=new GrnHeader($header_data);
            $header->save();
            if(isset($request->details)){
                foreach($request->details as $element){
                    $detail_data=[
                        'item'=>$element['item'],
                        'purchase_price'=>$element['label_price'],
                        'discount'=>$element['discount'],
                        'cost_price'=>$element['label_price']-$element['discount'],
                        'purchase_qty'=>$element['quantity'],
                        'amount'=>$element['amount'],
                        'grn_header'=>$header->id,
                    ];
                    $detail=new GrnDetail($detail_data);
                    $detail->save();
                    $stock_data=[
                        'item'=>$element['item'],
                        'purchase_qty'=>$element['quantity'],
                        'qty_in_hand'=>$element['quantity'],
                        'cost_price'=>$detail->cost_price,
                        'sales_price'=>$element['label_price'],
                        'stock_type'=>'GRN',
                        'grn'=>$header->id,
                        //sales_rate
                    ];
                    $stock=new ItemStock($stock_data);
                    $stock->save();
                    $transaction_data=[
                        'stock_id'=>$stock->id,
                        'item'=>$element['item'],
                        'transaction_type'=>'GRN',
                        'tran_status'=>'completed',
                        'qih_before'=>0,
                        'qih_after'=>$element['quantity'],
                        'transfer_qty'=>$element['quantity'],
                        'reference_id'=>$header->id,
                    ];
                    $transaction=new ItemTransaction($transaction_data);
                    $transaction->save();
                    $stocks=ItemStock::where('item',$element['item'])->get();
                    foreach($stocks as $var){
                        $var->sales_price=$element['label_price'];
                        $var->sales_rate=($element['label_price']-$var->cost_price)/$var->cost_price;
                        $var->save();
                    }
                }
            }
            if(isset($request->free_details)){
                foreach($request->free_details as $element){
                    $free_data=[
                        'grn'=>$header->id,
                        'item'=>$element['item'],
                        'qty'=>$element['quantity'],
                    ];
                    $free_issue=new FreeIssue($free_data);
                    $free_issue->save();
                    $item_stock=ItemStock::where('item',$element['item'])->where('grn',$header->id)->first();
                    if($item_stock){
                        $item_stock->purchase_qty=$item_stock->purchase_qty+$element['quantity'];
                        $item_stock->qty_in_hand=$item_stock->qty_in_hand+$element['quantity'];
                        $item_stock->save();
                        $transaction_data=[
                            'stock_id'=>$item_stock->id,
                            'item'=>$element['item'],
                            'transaction_type'=>'Free Issue',
                            'tran_status'=>'completed',
                            'qih_before'=>$item_stock->qty_in_hand-$element['quantity'],
                            'qih_after'=>$item_stock->qty_in_hand,
                            'transfer_qty'=>$element['quantity'],
                            'reference_id'=>$free_issue->id,
                        ];
                        $transaction=new ItemTransaction($transaction_data);
                        $transaction->save();
                         //check for item type when setting the price
                    }else{
                        $item_stock=ItemStock::where('item',$element['item'])->orderBy('id','desc')->first();
                        $stock_data=[
                            'item'=>$element['item'],
                            'purchase_qty'=>$element['quantity'],
                            'qty_in_hand'=>$element['quantity'],
                            'cost_price'=>$item_stock->cost_price,
                            'sales_price'=>$item_stock->sales_price,
                            'stock_type'=>'Free Issue',
                            'grn'=>$header->id,
                            //sales_rate
                        ];
                        $stock=new ItemStock($stock_data);
                        $stock->save();
                        $transaction_data=[
                            'stock_id'=>$stock->id,
                            'item'=>$element['item'],
                            'transaction_type'=>'Free Issue',
                            'tran_status'=>'completed',
                            'qih_before'=>0,
                            'qih_after'=>$element['quantity'],
                            'transfer_qty'=>$element['quantity'],
                            'reference_id'=>$header->id,
                        ];
                        $transaction=new ItemTransaction($transaction_data);
                        $transaction->save();
                        //check for item type when setting the price
                    }
                }
            }
            DB::commit();
            return redirect()->back()->with('success','GRN Stored Successfully!!!');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }

    public function grn_index(){
        return view('pages.grn.index');
    }

    public function grn_get_all(Request $request){
        $columns = [
            0 =>'grn_code',
            1 =>'supplier',
            2=> 'amount',
            3=> 'paid_amount',
            4=> 'return_amount',
            5=> 'balance',
        ];
        $totalData = GrnHeader::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $grns = GrnHeader::join('supplier','grn_header.supplier','=','supplier.id')
                    ->select('grn_header.*','supplier.supplier_name as supplier_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $grns =  GrnHeader::join('supplier','grn_header.supplier','=','supplier.id')
                        ->select('grn_header.*','supplier.supplier_name as supplier_name')
                        ->where('grn_header.grn_code','LIKE',"%{$search}%")
                        ->orWhere('supplier.supplier_name', 'LIKE',"%{$search}%")
                        ->orWhere('grn_header.receipt_no', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = GrnHeader::join('supplier','grn_header.supplier','=','supplier.id')
                        ->select('grn_header.*','supplier.supplier_name as supplier_name')
                        ->where('grn_header.grn_code','LIKE',"%{$search}%")
                        ->orWhere('supplier.supplier_name', 'LIKE',"%{$search}%")
                        ->orWhere('grn_header.receipt_no', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($grns) ) {
            foreach ($grns as $item)
                {
                    $grn['grn_code'] = $item->grn_code;
                    $grn['supplier'] = $item->supplier_name;
                    $grn['amount'] = $item->amount;
                    $grn['paid_amount'] = $item->paid_amount;
                    $grn['return_amount'] = $item->return_amount;
                    $grn['balance'] = $item->balance;
                    $grn['action'] = '<div class="btn-group">
                    <a href="#'.$item->id.'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    </div>';
                    $data[] = $grn;

                }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
            );

        echo json_encode($json_data);
    }
}
