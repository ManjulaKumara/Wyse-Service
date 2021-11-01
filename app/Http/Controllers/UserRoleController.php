<?php

namespace App\Http\Controllers;

use App\Models\modules;
use Illuminate\Http\Request;
use App\Models\UserRole;
use Exception;
use Illuminate\Support\Facades\DB;

class UserRoleController extends Controller
{
    public function user_role_index(){
        $user_role = UserRole::orderBy('id')->get();
        view()->share('user_role',$user_role);
        return view('pages.MasterFile.user_role.index');
    }

    public function user_role_getAll(Request $request){
        $columns = [
            0 =>'id',
            1 =>'role_code',
            2=> 'role_name',
            3=> 'is_active',
        ];
        $totalData = UserRole::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $user_role = UserRole::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $user_role =  UserRole::where('role_code','LIKE',"%{$search}%")
                        ->orWhere('role_name', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = UserRole::where('role_code','LIKE',"%{$search}%")
                        ->orWhere('role_name', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($user_role) ) {
            foreach ($user_role as $item)
                {
                    $role['id'] = $item->id;
                    $role['role_code'] = $item->role_code;
                    $role['role_name'] = $item->role_name;
                    $role['is_active'] = ($item->is_active==1)?'Active':'Inactive';
                    $role['action'] = '<div class="btn-group">
                    <a href="/user-role/view/'.$item->id.'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    <a href="/user-role/edit/'.$item->id.'" class="btn btn-xs  btn-warning " title="Update">
                            <i class="fa fa-edit"></i>
                    </a>
                    </div>';
                    $data[] = $role;

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

    public function user_role_create(){
        return view('pages.MasterFile.user_role._form');
    }

    public function user_role_store(Request $request){
        try {
            // dd($request->all());
            $user_role=new UserRole();
            $user_role->role_code = $request->get('role_code');
            $user_role->role_name = $request->get('role_name');
            $user_role->is_active = $request->get('is_active');
            $user_role->save();

            foreach ($request->element as $key=>$value){
                $module_code=0;
                $md_group=0;
                $is_enable=0;
                $can_read=0;
                $can_create=0;
                $can_update=0;
                $can_delete=0;
                foreach($value as $index=>$element){
                    if(!empty($value[0])){
                        $module_code=$value[0][0];
                    }
                    if(!empty($value[1])){
                        $md_group=$value[1][0];
                    }
                    if(!empty($value[2])){
                        $is_enable=1;
                    }
                    if(!empty($value[3])){
                        $can_read=1;
                    }
                    if(!empty($value[4])){
                        $can_create=1;
                    }
                    if(!empty($value[5])){
                        $can_update=1;
                    }
                    if(!empty($value[6])){
                        $can_delete=1;
                    }
                }

                    $data[] = [
                        'role_id' =>$user_role->id,
                        'md_code' =>$module_code,
                        'md_group' =>$md_group,
                        'is_enable' => $is_enable,
                        'can_create' =>$can_create,
                        'can_read' => $can_read,
                        'can_update' =>$can_update,
                        'can_delete' => $can_delete,
                    ];
            }
            DB::table('user_role_permissions')->insert($data);

            $notification = array(
                'message' => 'Successfully Created!',
                'alert-type' => 'success'
            );

            return redirect('user-role/all')->with($notification);
        } catch (Exception $e) {
            return back()->withInput()->withErrors('Something went wrong!');
        }
    }

    public function user_role_view($id){
        $user_role = UserRole::find($id);
        view()->share('user_role',$user_role);
        return view('pages.MasterFile.user_role._form');
    }

    public function user_role_edit($id){
        $user_role = UserRole::find($id);
        view()->share('user_role',$user_role);
        return view('pages.MasterFile.user_role._form');
    }

    public function user_role_update(Request $request, $id){
        try {
            $user_role = UserRole::find($id);
            $user_role->role_code = $request->get('role_code');
            $user_role->role_name = $request->get('role_name');
            $user_role->is_active = $request->get('is_active');
            $user_role->save();

            DB::table('user_role_permissions')->where('role_id',$id)->where('md_code','<>','modules')->delete();
            foreach ($request->element as $key=>$value){
                $module_code=0;
                $md_group=0;
                $is_enable=0;
                $can_read=0;
                $can_create=0;
                $can_update=0;
                $can_delete=0;
                foreach($value as $index=>$element){
                    if(!empty($value[0])){
                        $module_code=$value[0][0];
                    }
                    if(!empty($value[1])){
                        $md_group=$value[1][0];
                    }
                    if(!empty($value[2])){
                        $is_enable=1;
                    }
                    if(!empty($value[3])){
                        $can_read=1;
                    }
                    if(!empty($value[4])){
                        $can_create=1;
                    }
                    if(!empty($value[5])){
                        $can_update=1;
                    }
                    if(!empty($value[6])){
                        $can_delete=1;
                    }
                }

                    $data[] = [
                        'role_id' =>$user_role->id,
                        'md_code' =>$module_code,
                        'md_group' =>$md_group,
                        'is_enable' => $is_enable,
                        'can_create' =>$can_create,
                        'can_read' => $can_read,
                        'can_update' =>$can_update,
                        'can_delete' => $can_delete,
                    ];
            }
            DB::table('user_role_permissions')->insert($data);

            $notification = array(
                'message' => 'Successfully Updated!',
                'alert-type' => 'success'
            );

            return redirect('user-role/all')->with($notification);
        } catch (Exception $e) {
            return back()->withInput()->withErrors('Something went wrong!');
        }
    }
}
