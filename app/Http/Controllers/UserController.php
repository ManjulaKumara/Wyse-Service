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
            return redirect('/users/all')->with($notification);

        } catch (Exception $e) {
            return back()->withInput()->withErrors('Error..!');
        }
    }
}
