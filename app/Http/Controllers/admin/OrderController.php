<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
class OrderController extends Controller
{
    public function fetchOrder()
    {
        $orders = Order::with('orderItems')->get();
    
        if ($orders->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No order found!'
            ], 404);
        } else {
            return response()->json([
                'status' => 200,
                'data' => $orders
            ], 200);
        }
    }
    public function singleOrderDetail($id)
    {
        $order = Order::with('orderItems')->find($id);
    
        if ($order==null) {
            return response()->json([
                'status' => 404,
                'message' => 'No order found!'
            ], 404);
        } else {
            return response()->json([
                'status' => 200,
                'data' => $order
            ], 200);
        }
    }
    public function updateOrder(Request $request,$id){
        
        $order = Order::where('id', $id)
        ->first();    
        if ($order==null) {
            return response()->json([
                'status' => 404,
                'message' => 'No order found!'
            ], 404);
        } else {
            $order->update([
                'payment_status'=>$request->payment_status,
                'status'=>$request->status,
            ]);
            return response()->json([
                'status' => 200,
                'data' => "Order Updated Sussesssfully"
            ], 200);
        }
    }


}
