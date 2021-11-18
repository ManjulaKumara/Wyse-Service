<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemRelationship;
use Illuminate\Support\Facades\DB;

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
            $relationship->save();
            DB::commit();
            return redirect()->back()->with('success','Item Relationship Stored Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }

    public function relation_index(){
        return view('pages.item-relationship.index');
    }

    public function relation_get_all(Request $request){
        $columns = [
            0 =>'parent_item',
            1 =>'child_item',
            2=> 'units_per_parent',
        ];
        $totalData = ItemRelationship::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $relations = ItemRelationship::join('items as parent_item','item_relationship.parent_item','=','parent_item.id')
                    ->join('items as child_item','item_relationship.child_item','=','child_item.id')
                    ->select('item_relationship.*','parent_item.item_name as parent_name','child_item.item_name as child_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $relations = ItemRelationship::join('items as parent_item','item_relationship.parent_item','=','parent_item.id')
                        ->join('items as child_item','item_relationship.child_item','=','child_item.id')
                        ->select('item_relationship.*','parent_item.item_name as parent_name','child_item.item_name as child_name')
                        ->where('item_relationship.units_per_parent','LIKE',"%{$search}%")
                        ->orWhere('parent_item.item_name', 'LIKE',"%{$search}%")
                        ->orWhere('child_item.item_name', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = ItemRelationship::join('items as parent_item','item_relationship.parent_item','=','parent_item.id')
                        ->join('items as child_item','item_relationship.child_item','=','child_item.id')
                        ->select('item_relationship.*','parent_item.item_name as parent_name','child_item.item_name as child_name')
                        ->where('item_relationship.units_per_parent','LIKE',"%{$search}%")
                        ->orWhere('parent_item.item_name', 'LIKE',"%{$search}%")
                        ->orWhere('child_item.item_name', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($relations) ) {
            foreach ($relations as $item)
                {
                    $relation['parent_item'] = $item->parent_name;
                    $relation['child_item'] = $item->child_name;
                    $relation['units_per_parent'] = $item->units_per_parent;
                    $relation['action'] = '<div class="btn-group">
                        <a href="/item-relationship/edit/'.$item->id.'" class="btn btn-xs  btn-warning " title="Update"><i class="fa fa-edit"></i></a>
                        </div>';
                    $data[] = $relation;

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

    public function relation_edit($id){
        $items=Item::where('is_active',1)->get();
        view()->share('items',$items);
        $rela = ItemRelationship::find($id);
        view()->share('relation',$rela);
        return view('pages.item-relationship.item-relationship');
    }

    public function relation_update(Request $request, $id){
        try {
            $relation = ItemRelationship::find($id);
            $relation->parent_item = $request->parent_item;
            $relation->child_item = $request->child_item;
            $relation->units_per_parent = $request->units_per_parent;
            $relation->save();
            return redirect('/item-relationship/all')->with('success','Item Relationship Updated Successfully!!!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }
}
