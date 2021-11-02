<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Item;
use App\Models\GrnHeader;
use App\Models\GrnDetails;
use App\Models\ItemStock;
use App\Models\FreeIssue;
use App\Models\ItemTransaction;
use DB;
use DateTime;


class GrnController extends Controller
{
    public function code_Create() {
        $max_code=DB::select("select grn_code  from grn_header  ORDER BY RIGHT(grn_code , 10) DESC");
        $Regi=null;
        if(sizeof($max_code)==0) {
            $new_code=0;
        } else {
            $last_code_no=$max_code[0]->invoice_number;
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
                foreach($details as $element){
                    $item=Item::find($element['item']);
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
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }
}
