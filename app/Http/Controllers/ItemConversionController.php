<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemRelationship;
use App\Models\Item;
use App\Models\ItemStock;
use App\Models\ItemTransaction;
use App\Models\ItemConvertion;
use DB;
use DateTime;

class ItemConversionController extends Controller
{
    public function create(){
        $parents=ItemRelationship::distinct()->get('parent_item');
        $parent_items=[];
        foreach($parents as $element){
            $item=Item::find($element->parent_item);
            array_push($parent_items,$item);
        }
        view()->share('parent_items',$parent_items);
        $today=new DateTime();
        $today=$today->format('d/m/Y');
        view()->share('today',$today);
        return view('pages.item-conversion.item-conversion');
    }

    public function get_child_items($parent){
        $relationships=ItemRelationship::where('parent_item',$parent)->get();
        $child_items=[];
        foreach($relationships as $element){
            $item=Item::find($element->child_item);
            array_push($child_items,(object)['item_name'=>$item->item_name,'id'=>$item->id,'units_per_parent'=>$element->units_per_parent,'code'=>$item->item_code,'barcode'=>$item->barcode]);
        }
        return response()->json($child_items,200);
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $convert_data=[
                'from_item'=>$request->from_item,
                'to_item'=>$request->to_item,
                'from_qty'=>$request->from_quantity,
                'to_qty'=>$request->to_quantity,
            ];
            $conversion=new ItemConvertion($convert_data);
            $conversion->save();
            $parent_stock=ItemStock::where('item',$request->from_item)->orderBy('id','desc')->first();
            $parent_stock->qty_in_hand=$parent_stock->qty_in_hand-$request->from_quantity;
            $parent_stock->save();
            $item_qtys=ItemStock::where('item',$request->from_item)->sum('qty_in_hand');
            $transaction_data=[
                'stock_id'=>$parent_stock->id,
                'item'=>$request->from_item,
                'transaction_type'=>'item conversion(from)',
                'trans_status'=>'out',
                'qih_before'=>$request->from_quantity,
                'qih_after'=>$parent_stock->qty_in_hand,
                'transfer_qty'=>$request->from_quantity,
                'reference_id'=>$conversion->id,
                'total_qih_before'=>$item_qtys+$request->from_quantity,
                'total_qih_after'=>$item_qtys,
            ];
            $transaction=new ItemTransaction($transaction_data);
            $transaction->save();
            $child_stock=ItemStock::where('item',$request->to_item)->orderBy('id','desc')->first();
            $stock_data=[
                'item'=>$request->to_item,
                'purchase_qty'=>$request->to_quantity,
                'qty_in_hand'=>$request->to_quantity,
                'cost_price'=>$child_stock->cost_price,
                'grn'=>$conversion->id,
                'sales_price'=>$child_stock->sales_price,
                'sales_rate'=>$child_stock->sales_rate,
                'stock_type'=>'item-conversion',
            ];
            $new_stock=new ItemStock($stock_data);
            $new_stock->save();
            $item_qtys=ItemStock::where('item',$request->to_item)->sum('qty_in_hand');
            $new_transaction_data=[
                'stock_id'=>$parent_stock->id,
                'item'=>$request->to_item,
                'transaction_type'=>'item conversion(to)',
                'trans_status'=>'in',
                'qih_before'=>0,
                'qih_after'=>$request->to_quantity,
                'transfer_qty'=>$request->to_quantity,
                'reference_id'=>$conversion->id,
                'total_qih_before'=>$item_qtys-$request->to_quantity,
                'total_qih_after'=>$item_qtys,
            ];
            $new_transaction=new ItemTransaction($new_transaction_data);
            $new_transaction->save();
            DB::commit();
            return redirect()->back()->with('success','Item Conversion Stored Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }
}
