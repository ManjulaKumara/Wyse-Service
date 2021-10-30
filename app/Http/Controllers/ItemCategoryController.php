<?php

namespace App\Http\Controllers;

use App\Models\ItemCategorie;
use Illuminate\Http\Request;
use Exception;

class ItemCategoryController extends Controller
{
    public function item_category_index(){
        return view('pages.MasterFile.item_category.index');
    }

    public function item_category_create(){
        return view('pages.MasterFile.item_category._form');
    }

    public function item_category_store(Request $request){
        try {
            $category = new ItemCategorie();
            $category->category_name = $request->get('category_name');
            $category->category_code = $request->get('category_code');
            $category->remarks = $request->get('remarks');
            $category->is_active = $request->get('is_active');
            $category->save();

            $notification = array(
                'message' => 'Successfully Created!',
                'alert-type' => 'success'
            );
            return redirect('/item-category/all')->with($notification);

        } catch (Exception $e) {
            return back()->withInput()->withErrors('Error..!');
        }
    }
}
