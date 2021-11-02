<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemRelationship;
use DB;

class ItemRelationshipController extends Controller
{
    public function create(){
        $items=Item::where('is_active',1)->get();
        view()->share('items',$items);
        return view('pages.item-relationship.item-relationship');
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $relationship_data=[
                'parent_item'=>$request->parent_item,
                'child_item'=>$request->child_item,
                'units_per_parent'=>$request->units_per_parent,
            ];
            $relationship=new ItemRelationship($relationship_data);
            DB::commit();
            return redirect()->back()->with('success','Item Relationship Stored Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }
}
