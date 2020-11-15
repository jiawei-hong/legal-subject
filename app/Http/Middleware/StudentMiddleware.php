<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class StudentMiddleware
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

        if($data['permission'] == '學生'){
            return $next($request);
        }
    }
}
