<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $fields= $request->validate([
           'name'=> 'required|string',
           'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);

        //genberate sql and insert into database
        $user=User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
            ]);

        $token=$user->createToken('apptoken')->plainTextToken;

        $response=[
            'user'=>$user,
            'token'=>$token
        ];

        return response($response,201);
    }

    public function login(Request $request){
        $fields=$request->validate([
            'email'=> 'required|string|email',
            'password' => 'required|string'
        ]);

        $user=User::where('email',$fields['email'])->first();
        if($user==null){
            return response(json_encode([
                "message"=>"Invalid credential"
            ]),401);
        }
        $hash=bcrypt($fields['password']);
        if(Hash::check($fields['password'],$user->password )){
            $token=$user->createToken('apptoken')->plainTextToken;
            $response=[
                'user'=>$user,
                'token'=>$token
            ];

            return response($response,200);
        }
        else{
            return response(json_encode([
             "message"=>"Invalid credential"
            ]),401);
        }
    }
}
