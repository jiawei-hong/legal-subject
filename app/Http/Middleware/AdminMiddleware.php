<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(count($request->all()) === 0){
            return response('Permission Denied',403);
        }

        $data = User::where('api_token',$request['token'])->first();

        if($data['permission'] == '管理員'){
            return $next($request);
        }
    }
}
