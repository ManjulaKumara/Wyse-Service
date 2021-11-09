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

    public function item_category_get_all(Request $request){
        $columns = [
            0 =>'id',
            1 =>'category_code',
            2=> 'category_name',
            3=> 'is_active',
        ];
        $totalData = ItemCategorie::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $categories = ItemCategorie::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $categories =  ItemCategorie::where('category_code','LIKE',"%{$search}%")
                        ->orWhere('category_name', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = ItemCategorie::where('category_code','LIKE',"%{$search}%")
                        ->orWhere('category_name', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($categories) ) {
            foreach ($categories as $item)
                {
                    $category['id'] = $item->id;
                    $category['category_code'] = $item->category_code;
                    $category['category_name'] = $item->category_name;
                    $category['is_active'] = ($item->is_active==1)?'Active':'Inactive';
                    $category['action'] = '<div class="btn-group">
                    <a href="/item-category/view/'.$item->id.'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    <a href="/item-category/edit/'.$item->id.'" class="btn btn-xs  btn-warning " title="Update">
                            <i class="fa fa-edit"></i>
                    </a>
                    </div>';
                    $data[] = $category;

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
            return redirect('/item-category/all')->with('success','Item Category Stored Successfully!!!');

        } catch (Exception $e) {
            return back()->withInput()->with('error','Something went wrong!!!');
        }
    }

    public function item_category_view($id){
        $category = ItemCategorie::find($id);
        view()->share('category',$category);
        return view('pages.MasterFile.item_category._form');
    }

    public function item_category_edit($id){
        $category = ItemCategorie::find($id);
        view()->share('category',$category);
        return view('pages.MasterFile.item_category._form');
    }

    public function item_category_update(Request $request, $id){
        try {
            $category = ItemCategorie::find($id);
            $category->category_name = $request->get('category_name');
            $category->category_code = $request->get('category_code');
            $category->remarks = $request->get('remarks');
            $category->is_active = $request->get('is_active');
            $category->save();

            $notification = array(
                'message' => 'Successfully Updated!',
                'alert-type' => 'success'
            );
            return redirect('/item-category/all')->with('success','Item Category Updated Successfully!!!');

        } catch (Exception $e) {
            return back()->withInput()->with('error','Something went wrong!!!');
        }
    }
}
