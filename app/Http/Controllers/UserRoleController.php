<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRole;
use Exception;

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
                    $role['is_active'] = $item->is_active;
                    $role['action'] = '<div class="btn-group">
                    <a href="#" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    <a href="#" class="btn btn-xs  btn-warning " title="Update">
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
            $user_role=new UserRole();
            $user_role->role_code = $request->get('role_code');
            $user_role->role_name = $request->get('role_name');
            $user_role->is_active = $request->get('is_active');
            $user_role->save();

            $notification = array(
                'message' => 'Successfully Created!',
                'alert-type' => 'success'
            );

            return redirect('user-role/all')->with($notification);
        } catch (Exception $e) {
            return back()->withInput()->withErrors('Error..!');
        }
    }
}
