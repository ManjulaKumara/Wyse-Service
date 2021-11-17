<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserRole;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function users_index(){
        return view('pages.MasterFile.users.index');
    }

    public function users_get_all(Request $request){
        $columns = [
            0 =>'id',
            1 =>'name',
            2=> 'email',
            3=> 'is_active',
        ];
        $totalData = User::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if( empty($request->input('search.value')) ) {
            $users = User::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $users =  User::where('name','LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = User::where('name','LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%")
                        ->orWhere('id', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if( !empty($users) ) {
            foreach ($users as $item)
                {
                    $user['id'] = $item->id;
                    $user['name'] = $item->name;
                    $user['email'] = $item->email;
                    $user['is_active'] = ($item->is_active==1)?'Active':'Inactive';
                    $user['action'] = '<div class="btn-group">
                    <a href="/user/view/'.$item->id.'" class="btn btn-xs  btn-success " title="View"><i class="fa fa-eye"></i>
                    </a>
                    <a href="/user/edit/'.$item->id.'" class="btn btn-xs  btn-warning " title="Update">
                            <i class="fa fa-edit"></i>
                    </a>
                    </div>';
                    $data[] = $user;

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

    public function user_create(){
        $user_role = UserRole::where('is_active',1)->get();
        view()->share('user_roles',$user_role);
        return view('pages.MasterFile.users._form');
    }

    public function user_store(Request $request){
        try {
            if ($request->get('password')!=$request->get('com_password')) {
                $notification = array(
                    'message' => 'Passwaord Not Match'
                );
                return back()->withInput()->withErrors($notification);
            }
            $user_email=User::where('email',$request->get('email'))->get();
            if(sizeof($user_email)>0){
                echo "success";
                $notification = array(
                    'message' => 'Email is Already Taken'
                );
                return back()->withInput()->withErrors($notification);
            }

            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->user_role = $request->get('user_role');
            $user->is_active = $request->get('is_active');
            $user->save();

            $notification = array(
                'message' => 'Successfully Created!',
                'alert-type' => 'success'
            );
            return redirect('/user/all')->with('success','User Stored Successfully!!!');

        } catch (Exception $e) {
            return back()->withInput()->with('error','Something went wrong!!!');
        }
    }

    public function user_view($id){
        $user_role = UserRole::where('is_active',1)->get();
        view()->share('user_roles',$user_role);
        $user = User::find($id);
        view()->share('user',$user);
        return view('pages.MasterFile.users._form');
    }

    public function user_edit($id){
        $user_role = UserRole::where('is_active',1)->get();
        view()->share('user_roles',$user_role);
        $user = User::find($id);
        view()->share('user',$user);
        return view('pages.MasterFile.users._form');
    }

    public function user_update(Request $request, $id){
        try {
            $user = User::find($id);
            if ($request->get('password')!=$request->get('com_password')) {
                $notification = array(
                    'message' => 'Passwaord Not Match'
                );
                return back()->withInput()->withErrors($notification);
            }
            if ($user->email!=$request->get('email')) {
                $user_email=User::where('email',$request->get('email'))->get();
                if(sizeof($user_email)>0){
                    echo "success";
                    $notification = array(
                        'message' => 'Email is Already Taken'
                    );
                    return back()->withInput()->withErrors($notification);
                }
            }

            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->user_role = $request->get('user_role');
            $user->is_active = $request->get('is_active');
            $user->save();

            $notification = array(
                'message' => 'Successfully Updated!',
                'alert-type' => 'success'
            );
            return redirect('/user/all')->with('success','User Updated Successfully!!!');

        } catch (Exception $e) {
            return back()->withInput()->with('error','Something went wrong!!!');
        }
    }
}
