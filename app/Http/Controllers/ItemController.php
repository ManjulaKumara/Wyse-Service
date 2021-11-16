<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategorie;
use App\Models\ItemStock;
use Illuminate\Http\Request;
use Exception;
use DB;

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
            3=> 'category',
            4=> 'is_active',
        ];
        $totalData = Item::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $items = Item::join('item_categories','items.category','=','item_categories.id')
                    ->select('items.*','item_categories.category_name as category_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $items =  Item::join('item_categories','items.category','=','item_categories.id')
                        ->select('items.*','item_categories.category_name as category_name')
                        ->where('items.item_code','LIKE',"%{$search}%")
                        ->orWhere('items.item_name', 'LIKE',"%{$search}%")
                        ->orWhere('item_categories.category_name', 'LIKE',"%{$search}%")
                        ->orWhere('items.barcode', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = Item::join('item_categories','items.category','=','item_categories.id')
                        ->select('items.*','item_categories.category_name as category_name')
                        ->where('items.item_code','LIKE',"%{$search}%")
                        ->orWhere('items.item_name', 'LIKE',"%{$search}%")
                        ->orWhere('item_categories.category_name', 'LIKE',"%{$search}%")
                        ->orWhere('items.barcode', 'LIKE',"%{$search}%")
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
                    $item['category'] = $value->category_name;
                    $item['is_active'] = ($value->is_active==1)?'Active':'Inactive';
                    $item['action'] = '<div class="btn-group">
                    <a href="/items/view/'.$value->id.'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    <a href="/items/edit/'.$value->id.'" class="btn btn-xs  btn-warning " title="Update">
                            <i class="fa fa-edit"></i>
                    </a>';
                    if($item_stock){
                        $item['action']=$item['action'].'<button class="btn btn-xs btn-primary update-price" data-current="'.$item_stock->sales_price.'" data-id="'.$value->id.'" data-name="'.$value->item_name.'" data-cost="'.$item_stock->cost_price.'" data-discount=""  title="Update Price">
                        <i class="fas fa-coins"></i>
                    </button>
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
            return redirect('/items/all')->with('success','Item Stored Successfully!!!');

        } catch (Exception $e) {
            return back()->withInput()->with('error','Something went wrong!!!');
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
            return redirect('/items/all')->with('success','Item Updated Successfully!!!');

        } catch (Exception $e) {
            return back()->withInput()->with('error','Something went wrong!!!');
        }
    }

    public function update_price(Request $request){
        try {
            DB::beginTransaction();
            $stocks=ItemStock::where('item',$request->item)->get();
            foreach($stocks as $var){
                $var->sales_price=$request->new_price;
                $var->sales_rate=($request->new_price-$var->cost_price)/$var->cost_price;
                $var->save();
            }
            DB::commit();
            return redirect()->back()->with('success','Price updated Successfully!!!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Something went wrong!!');;
        }
    }

    public function getItem($id){
        $items=Item::where('item_name','like','%'.$key.'%')->orWhere('item_code','like','%'.$key.'%')->orWhere('barcode','like','%'.$key.'%')->get();

    }
}
