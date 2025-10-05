<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class PasswrodController extends Controller
{
    public function editCustomerPassword(Request $request){
        // Step 1: Validate input
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed', 
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }
    
        $user = auth()->user();
    
        // Step 2: Check old password
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => 400,
                'message' => 'Old password is incorrect.'
            ], 400);
        }
    
        // Step 3: Update new password
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return response()->json([
            'status' => 200,
            'message' => 'Password updated successfully.'
        ], 200);
    }
}
