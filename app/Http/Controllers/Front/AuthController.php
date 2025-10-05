<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
class AuthController extends Controller
{
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            "name"=>"required",
            "email"=>"required|email",
            "password"=>"required|min:6",
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()
            ],400);
        }
         User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password' => Hash::make($request->password)

         ]);
         return response()->json([
            'status'=>200,
            'data'=>"User has been registered successfully!"
         ],200);

    }
    public function authentication(Request $request){
        $validator=Validator::make($request->all(),[
            "email"=>"required|email",
            "password"=>"required|min:6",
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()
            ],400);
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
              $user=Auth::user();
              $token=$user->createToken('customer-token')->plainTextToken;


              return response()->json([
                'status'=>200,
                'token'=>$token,
                'data'=>$user
            ],200);

        }else{
            return response()->json([
                'status'=>401,
                'errors'=>"Invalid Email/Password"
            ],401);
        }
    }
    public function getCustomerDetail(){
        $user = Auth::user(); // ya auth()->user()

        return response()->json([
            'status' => 200,
            'data' => $user,
        ]);
    }
    // public function updatePassword(Request $request){
    //     // Step 1: Validate input
    //     $validator = Validator::make($request->all(), [
    //         'old_password' => 'required',
    //         'new_password' => 'required|min:6|confirmed', 
    //     ]);
    
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 400,
    //             'message' => 'Validation failed',
    //             'errors' => $validator->errors()
    //         ], 400);
    //     }
    
    //     $user = auth()->user();
    
    //     // Step 2: Check old password
    //     if (!Hash::check($request->old_password, $user->password)) {
    //         return response()->json([
    //             'status' => 400,
    //             'message' => 'Old password is incorrect.'
    //         ], 400);
    //     }
    
    //     // Step 3: Update new password
    //     $user->password = Hash::make($request->new_password);
    //     $user->save();
    
    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Password updated successfully.'
    //     ], 200);
    // }
 
}