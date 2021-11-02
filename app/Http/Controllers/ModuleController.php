<?php

namespace App\Http\Controllers;

use App\Models\Modules;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function module_index(){
        return view('pages.MasterFile.modules.index');
    }

    public function module_get_all(Request $request){
        $columns = [
            0 =>'id',
            1 =>'md_code',
            2=> 'md_name',
            3=> 'is_active',
        ];
        $totalData = Modules::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $modules = Modules::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $modules =  Modules::where('md_code','LIKE',"%{$search}%")
                        ->orWhere('md_name', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = Modules::where('md_code','LIKE',"%{$search}%")
                        ->orWhere('md_name', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($modules) ) {
            foreach ($modules as $item)
                {
                    $module['id'] = $item->id;
                    $module['md_code'] = $item->md_code;
                    $module['md_name'] = $item->md_name;
                    $module['is_active'] = ($item->is_active==1)?'Active':'Inactive';
                    $module['action'] = '<div class="btn-group">
                    <a href="/module/view/'.$item->id.'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    <a href="/module/edit/'.$item->id.'" class="btn btn-xs  btn-warning " title="Update">
                            <i class="fa fa-edit"></i>
                    </a>
                    </div>';
                    $data[] = $module;

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

    public function module_create(){
        return view('pages.MasterFile.modules._form');
    }

    public function module_store(Request $request){
        try {
            $module = new Modules();
            $module->md_code = $request->get('md_code');
            $module->md_name = $request->get('md_name');
            $module->md_group = $request->get('md_group');
            $module->url = $request->get('url');
            $module->is_active = $request->get('is_active');
            $module->can_read = ($request->get('can_read')==1)?'on':'off';
            $module->can_create = ($request->get('can_create')==1)?'on':'off';
            $module->can_update = ($request->get('can_update')==1)?'on':'off';
            $module->can_delete = ($request->get('can_delete')==1)?'on':'off';
            $module->save();
            $notification = array(
                'message' => 'Successfully Created!',
                'alert-type' => 'success'
            );
            return redirect('/module/all')->with($notification);
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors('Something went wrong!');
        }
    }

    public function module_view($id){
        $module = Modules::find($id);
        view()->share('module',$module);
        return view('pages.MasterFile.modules._form');
    }

    public function module_edit($id){
        $module = Modules::find($id);
        view()->share('module',$module);
        return view('pages.MasterFile.modules._form');
    }

    public function module_update(Request $request, $id){
        try {
            $module = Modules::find($id);
            $module->md_code = $request->get('md_code');
            $module->md_name = $request->get('md_name');
            $module->md_group = $request->get('md_group');
            $module->url = $request->get('url');
            $module->is_active = $request->get('is_active');
            $module->can_read = ($request->get('can_read')==1)?'on':'off';
            $module->can_create = ($request->get('can_create')==1)?'on':'off';
            $module->can_update = ($request->get('can_update')==1)?'on':'off';
            $module->can_delete = ($request->get('can_delete')==1)?'on':'off';
            $module->save();
            $notification = array(
                'message' => 'Successfully Updated!',
                'alert-type' => 'success'
            );
            return redirect('/module/all')->with($notification);
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors('Something went wrong!');
        }
    }
}
