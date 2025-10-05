<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function authentication(Request $request){
        $validator=Validator::make($request->all(),[
            "email"=>"required|email",
            "password"=>"required|min:6",
        ]);
        if($validator->fails()){
            return response()->json([
                "status"=>400,
                "errors"=>$validator->errors()
            ],400);
        }
        $credentials=$request->only("email","password");   
        if(Auth::attempt($credentials)){
           $user=Auth::user();
           if($user->role === 'admin'){
            $token=$user->createToken('token')->plainTextToken;
            return response()->json([
                "status"=>200,
                "id"=>$user->id,
                "name"=>$user->name,
                "token"=>$token,
             ],200);
           }
           else{
             return response()->json([
                "status"=>403,
                "message"=>"You are not authroized to access admin panel"
             ],403);
           }
        }
        else{
            return response([
                "status"=>401,
                "message"=>"Either email/password is incorrect",
            ],401);
        }

    }
}
