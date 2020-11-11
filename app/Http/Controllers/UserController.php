<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected function create()
    {
        $user = User::forceCreate([
            'username' => 'admin',
            'account' => 'admin',
            'password' => Hash::make('1234'),
            'api_token' => Str::random(80),
        ]);

        return [
            'status' => true,
            'data' => $user->api_token
        ];
    }

    protected function login(Request $request)
    {
        $input = $request->all();
        $query = User::where(['account' => $input->account])->first();

        if(!is_null($query)){
            $password_correct = Hash::check($input->password,$query->password);

            if($password_correct){
                return [
                    'status' => true,
                    'data' => [
                        'username' => $query->username,
                        'token' => $query->api_token
                    ]
                ];
            }
        }

        return [
            'status' => false,
            'msg' => '帳號或密碼輸入錯誤。'
        ];
    }
}
