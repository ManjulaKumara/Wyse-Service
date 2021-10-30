<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategorie;
use Illuminate\Http\Request;
use Exception;

class ItemController extends Controller
{
    public function item_index(){
        return view('pages.MasterFile.items.index');
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
            return back()->withInput()->withErrors('Error..!');
        }
    }
}
