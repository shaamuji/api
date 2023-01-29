<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleIsQual
{
    /**
     * Handle an incoming request.
     * @param  int  $role_id
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role_id = 0 )
    {

        $currentUser = $request->user();
        if ($currentUser){
            if($role_id){
                return $role_id == $currentUser->role_id ?  $next($request) :  response()->json([
                    'error' => 'wrong role permisssions',
                    
                ])->setStatusCode(401) ;
            }else{
                return $next($request);
            }
        }

        // if($currentUser-)
        // return $next($request);

        // return function (){
            // var_dump($currentUser->role_id);
            var_dump($role_id);
        // };
    }
}
