<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemStock;
use App\Models\ItemCategorie;
use App\Models\StockIssue;
use App\Models\ItemTransaction;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;
use App\Models\MaterialIssue;

class MaterialIssueController extends Controller
{

    public function material_issues_index(){
        return view('pages.material-issues.index');
    }

    public function material_issues_get_all(Request $request){
        $columns = [
            0 =>'issue_no',
            1 =>'item',
            2=> 'quantity',
            3=> 'date',
        ];
        $totalData = MaterialIssue::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $issues = MaterialIssue::join('items','material_issues.item','=','items.id')
                    ->select('material_issues.*','items.item_name as item_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $issues =  MaterialIssue::join('items','material_issues.item','=','items.id')
                        ->select('material_issues.*','items.item_name as item_name')
                        ->where('material_issues.issue_no','LIKE',"%{$search}%")
                        ->orWhere('items.item_name', 'LIKE',"%{$search}%")
                        ->orWhere('material_issues.quantity', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = MaterialIssue::join('items','material_issues.item','=','items.id')
                        ->select('material_issues.*','items.item_name as item_name')
                        ->where('material_issues.issue_no','LIKE',"%{$search}%")
                        ->orWhere('items.item_name', 'LIKE',"%{$search}%")
                        ->orWhere('material_issues.quantity', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($issues) ) {
            foreach ($issues as $item)
                {
                    $issue['issue_no'] = $item->issue_no;
                    $issue['item'] = $item->item_name;
                    $issue['quantity'] = $item->quantity;
                    $issue['date'] = $item->created_at->format('Y-m-d');
                    $data[] = $issue;

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

    public function create(){
        $issue_number=$this->code_Create();
        view()->share('issue_number',$issue_number);
        $items=Item::where('is_active',1)->get();
        $item_list=[];
        foreach($items as $item){
            $item_qtys=ItemStock::where('item',$item->id)->sum('qty_in_hand');
            if($item_qtys>0){
                $category=ItemCategorie::find($item->category);
                $data=[
                    'id'=>$item->id,
                    'name'=>$item->item_name,
                    'category'=>$category->category_name,
                    'barcode'=>$item->barcode,
                    'qih'=>$item_qtys,
                    'type'=>'item',
                ];
                array_push($item_list,(object)$data);
            }
        }
        view()->share('item_list',$item_list);
        $today=new DateTime();
        $today=$today->format('d/m/Y');
        view()->share('today',$today);
        return view('pages.material-issues.material-issue');
    }
    public function code_Create() {
        $max_code=DB::select("select issue_no from material_issues ORDER BY RIGHT(issue_no , 5) DESC");
        $Regi=null;
        if(sizeof($max_code)==0) {
            $new_code=0;
        } else {
            $last_code_no=$max_code[0]->issue_no;
            list($Regi,$new_code) = explode('-', $last_code_no);
        }
        $new_code='MI'.'-'.sprintf('%05d', intval($new_code) + 1);
        return $new_code;
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            if(isset($request->details)){
                foreach($request->details as $element){
                    $item_stock=null;
                    $item_stock=ItemStock::where('item',$element['item'])->where('qty_in_hand','>=',$element['qty'])->orderBy('id')->first();
                    if($item_stock){
                        $issue_data=[
                            'issue_no'=>$element['issue_no'],
                            'item'=>$element['item'],
                            'quantity'=>$element['qty'],
                            'stock_no'=>$item_stock->id,
                        ];
                        $issue=new MaterialIssue($issue_data);
                        $issue->save();
                        $item_stock->qty_in_hand=$item_stock->qty_in_hand-$element['qty'];
                        $item_stock->save();
                        $item_qtys=ItemStock::where('item',$element['item'])->sum('qty_in_hand');
                        $transaction_data=[
                            'stock_id'=>$item_stock->id,
                            'item'=>$element['item'],
                            'transaction_type'=>'material-issue',
                            'tran_status'=>'out',
                            'qih_before'=>$item_stock->qty_in_hand+$element['qty'],
                            'qih_after'=>$item_stock->qty_in_hand,
                            'transfer_qty'=>$element['qty'],
                            'reference_id'=>$issue->id,
                            'total_qih_before'=>$item_qtys+$element['qty'],
                            'total_qih_after'=>$item_qtys,
                        ];
                        $transaction=new ItemTransaction($transaction_data);
                        $transaction->save();
                    }else{
                        $qty=0;
                        while($qty<=$element['qty']){
                            $item_stock=ItemStock::where('item',$element['item'])->where('qty_in_hand','>',0)->orderBy('id')->first();
                            $issue_data=[
                                'issue_no'=>$element['issue_no'],
                                'item'=>$element['item'],
                                'quantity'=>$item_stock->qty_in_hand,
                                'stock_no'=>$item_stock->id,
                            ];
                            $issue=new MaterialIssue($issue_data);
                            $issue->save();
                            $before=$item_stock->qty_in_hand;
                            $qty=$qty+$item_stock->qty_in_hand;
                            $item_stock->qty_in_hand=$item_stock->qty_in_hand-$item_stock->qty_in_hand;
                            $item_stock->save();
                            $item_qtys=ItemStock::where('item',$element['item'])->sum('qty_in_hand');
                            $transaction_data=[
                                'stock_id'=>$item_stock->id,
                                'item'=>$element['item'],
                                'transaction_type'=>'material-issue',
                                'tran_status'=>'out',
                                'qih_before'=>$before,
                                'qih_after'=>$item_stock->qty_in_hand,
                                'transfer_qty'=>$before,
                                'reference_id'=>$issue->id,
                                'total_qih_before'=>$item_qtys+$before,
                                'total_qih_after'=>$item_qtys,
                            ];
                            $transaction=new ItemTransaction($transaction_data);
                            $transaction->save();
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->back()->with('success','Stock Issues Stored Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }
}
