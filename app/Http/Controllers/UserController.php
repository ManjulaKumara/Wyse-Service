<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users_index(){
        return view('pages.MasterFile.user_role.index');
    }
}
