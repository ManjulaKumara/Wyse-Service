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

class StockIssueController extends Controller
{
    public function createIssues(){
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
        return view('pages.stock-issues.issue');
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
                            'vehicle_number'=>$element['vehicle_no'],
                            'item'=>$element['item'],
                            'qty'=>$element['qty'],
                            'stock_no'=>$item_stock->id,
                            'is_invoiced'=>0,
                        ];
                        $issue=new StockIssue($issue_data);
                        $issue->save();
                        $item_stock->qty_in_hand=$item_stock->qty_in_hand-$element['qty'];
                        $item_stock->save();
                        $item_qtys=ItemStock::where('item',$element['item'])->sum('qty_in_hand');
                        $transaction_data=[
                            'stock_id'=>$item_stock->id,
                            'item'=>$element['item'],
                            'transaction_type'=>'sales/stock-issue',
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
                                'vehicle_number'=>$element['vehicle_no'],
                                'item'=>$element['item'],
                                'qty'=>$item_stock->qty_in_hand,
                                'stock_no'=>$item_stock->id,
                                'is_invoiced'=>0,
                            ];
                            $issue=new StockIssue($issue_data);
                            $issue->save();
                            $before=$item_stock->qty_in_hand;
                            $qty=$qty+$item_stock->qty_in_hand;
                            $item_stock->qty_in_hand=$item_stock->qty_in_hand-$item_stock->qty_in_hand;
                            $item_stock->save();
                            $item_qtys=ItemStock::where('item',$element['item'])->sum('qty_in_hand');
                            $transaction_data=[
                                'stock_id'=>$item_stock->id,
                                'item'=>$element['item'],
                                'transaction_type'=>'sales/stock-issue',
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

    public function stock_issue_index(){
        return view('pages.stock-issues.index');
    }

    public function stock_issue_get_all(Request $request){
        $columns = [
            0 =>'vehicle_number',
            1 =>'item',
            2=> 'qty',
            3=> 'is_invoiced',
        ];
        $totalData = StockIssue::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $issues = StockIssue::join('items','stock_issue.item','=','items.id')
                    ->select('stock_issue.*','items.item_name as item_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $issues =  StockIssue::join('items','stock_issue.item','=','items.id')
                        ->select('stock_issue.*','items.item_name as item_name')
                        ->where('stock_issue.vehicle_number','LIKE',"%{$search}%")
                        ->orWhere('items.item_name', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = StockIssue::join('items','stock_issue.item','=','items.id')
                        ->select('stock_issue.*','items.item_name as item_name')
                        ->where('stock_issue.vehicle_number','LIKE',"%{$search}%")
                        ->orWhere('items.item_name', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($issues) ) {
            foreach ($issues as $item)
                {
                    $status=0;
                    if ($item->is_invoiced==0) {
                        $status='Not Invoiced';
                    } else if($item->is_invoiced==1){
                        $status='Invoiced';
                    } else{
                        $status='Returned';
                    }

                    $issue['vehicle_number'] = $item->vehicle_number;
                    $issue['item'] = $item->item_name;
                    $issue['qty'] = $item->qty;
                    $issue['is_invoiced'] = $status;
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
}
