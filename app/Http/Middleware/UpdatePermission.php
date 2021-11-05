<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRolePermission;

class UpdatePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()) {

            $module_code = $request->segment(1);
            $Permissions = UserRolePermission::where('role_id',Auth::user()->user_role)->where('md_code',$module_code)->first();

            if(isset($Permissions)){
             if($Permissions->can_update==1){
                 return $next($request);
               }
            }else{
             abort(403);
            }
         }

         abort(403);
    }
}
