<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockIssue;
use App\Models\ItemStock;
use DateTime;

class StockReturnController extends Controller
{
    public function create(){
        $today=new DateTime();
        $today=$today->format('d/m/Y');
        view()->share('today',$today);
        return view('pages.stock-return.stock-return');
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $stock_issue=StockIssue::find($request->stock_issue);
            $stock_issue->return_qty=$stock_issue->return_qty+$request->quantity;
            if($stock_issue->qty==$stock_issue->return_qty){
                $stock_issue->is_invoiced=2;
            }
            $stock_issue->save();
            $item_stock=ItemStock::find($stock_issue->stock_no);
            $item_stock->qty_in_hand=$item_stock->qty_in_hand+$request->quantity;
            $item_stock->save();
            $transaction_data=[
                'stock_id'=>$item_stock->id,
                'item'=>$item_stock->item,
                'transaction_type'=>'Stock returns',
                'tran_status'=>'complete',
                'qih_before'=>$item_stock->qty_in_hand-$request->quantity,
                'qih_after'=>$item_stock->qty_in_hand,
                'transfer_qty'=>$request->quantity,
                'reference_id'=>$stock_issue->id,
            ];
            $transaction=new ItemTransaction($transaction_data);
            $transaction->save();
            DB::commit();
            return redirect()->back()->with('success','Stock return Stored Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }
}
