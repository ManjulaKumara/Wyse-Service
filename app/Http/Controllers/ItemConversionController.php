<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemRelationship;
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
            array_push($child_items,(object)['item_name'=>$item->item_name,'id'=>$item->id,'units_per_parent'=>$element->units_per_parent,'code'=>$item->item_code,]);
        }
        return response()->json($child_items,200);
    }
}
