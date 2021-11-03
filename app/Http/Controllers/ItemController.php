<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategorie;
use App\Models\ItemStock;
use Illuminate\Http\Request;
use Exception;

class ItemController extends Controller
{
    public function item_index(){
        return view('pages.MasterFile.items.index');
    }

    public function item_get_all(Request $request){
        $columns = [
            0 =>'id',
            1 =>'item_code',
            2=> 'item_name',
            3=> 'item_type',
            4=> 'is_active',
        ];
        $totalData = Item::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $items = Item::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $items =  Item::where('item_code','LIKE',"%{$search}%")
                        ->orWhere('item_name', 'LIKE',"%{$search}%")
                        ->orWhere('item_type', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = Item::where('item_code','LIKE',"%{$search}%")
                        ->orWhere('item_name', 'LIKE',"%{$search}%")
                        ->orWhere('item_type', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($items) ) {
            foreach ($items as $value)
                {
                    $item_stock=ItemStock::where('item',$value->id)->orderBy('id','desc')->first();
                    $item['id'] = $value->id;
                    $item['item_code'] = $value->item_code;
                    $item['item_name'] = $value->item_name;
                    $item['item_type'] = $value->item_type;
                    $item['is_active'] = ($value->is_active==1)?'Active':'Inactive';
                    $item['action'] = '<div class="btn-group">
                    <a href="/items/view/'.$value->id.'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    <a href="/items/edit/'.$value->id.'" class="btn btn-xs  btn-warning " title="Update">
                            <i class="fa fa-edit"></i>
                    </a>';
                    if($item_stock){
                        $item['action']=$item['action'].'<a href="#" class="btn btn-xs  btn-primary" data-current="'.$item_stock->sales_price.'" data-name="'.$value->item_name.'" data-cost="'.$item_stock->cost_price.'" data-discount=""  title="Update Price" data-bs-toggle="modal" data-bs-target="#price_change">
                        <i class="fas fa-coins"></i>
                    </a>
                    </div>';
                    }

                    $data[] = $item;

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

    public function item_create(){
        $category = ItemCategorie::where('is_active',1)->get();
        view()->share('categories',$category);
        return view('pages.MasterFile.items._form');
    }

    public function item_store(Request $request){
        try {
            $item = new Item();
            $item->item_code = $request->get('item_code');
            $item->category = $request->get('category');
            $item->item_name = $request->get('item_name');
            $item->item_description = $request->get('item_description');
            $item->discount_rate = $request->get('discount_rate');
            $item->item_type = $request->get('item_type');
            $item->remarks = $request->get('remarks');
            $item->barcode = $request->get('barcode');
            $item->re_order_level = $request->get('re_order_level');
            $item->is_active = $request->get('is_active');
            $item->save();

            $notification = array(
                'message' => 'Successfully Created!',
                'alert-type' => 'success'
            );
            return redirect('/items/all')->with($notification);

        } catch (Exception $e) {
            return back()->withInput()->withErrors('Something went wrong!');
        }
    }

    public function item_view($id){
        $item = Item::find($id);
        view()->share('item',$item);
        $category = ItemCategorie::where('is_active',1)->get();
        view()->share('categories',$category);
        return view('pages.MasterFile.items._form');
    }

    public function item_edit($id){
        $item = Item::find($id);
        view()->share('item',$item);
        $category = ItemCategorie::where('is_active',1)->get();
        view()->share('categories',$category);
        return view('pages.MasterFile.items._form');
    }

    public function item_update(Request $request, $id){
        try {
            $item = Item::find($id);
            $item->item_code = $request->get('item_code');
            $item->category = $request->get('category');
            $item->item_name = $request->get('item_name');
            $item->item_description = $request->get('item_description');
            $item->discount_rate = $request->get('discount_rate');
            $item->item_type = $request->get('item_type');
            $item->remarks = $request->get('remarks');
            $item->barcode = $request->get('barcode');
            $item->re_order_level = $request->get('re_order_level');
            $item->is_active = $request->get('is_active');
            $item->save();

            $notification = array(
                'message' => 'Successfully Updated!',
                'alert-type' => 'success'
            );
            return redirect('/items/all')->with($notification);

        } catch (Exception $e) {
            return back()->withInput()->withErrors('Something went wrong!');
        }
    }
}
