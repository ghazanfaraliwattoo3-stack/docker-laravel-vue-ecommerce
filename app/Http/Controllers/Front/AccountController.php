<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function editUserDetail(Request $request){
        // dd(auth()->id());
        $user=User::where('id',auth()->id())->first();
        $user->update([
            'name'=>$request->name, 
            'email'=>$request->email, 
            'address'=>$request->address, 
            'city'=>$request->city, 
            'state'=>$request->state, 
            'zip'=>$request->zip, 
            'mobile'=>$request->mobile, 
        ]); 
        $user=User::where('id',auth()->id())->first();
          return response()->json([
            'message'=>"Profile update Successfylly! "
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
