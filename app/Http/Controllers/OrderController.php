<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Size;
class OrderController extends Controller
{
    public function saveOrder(Request $request)
    {
        
        try{
            // Check if cart is not empty
        if ($request->cart) {
            // Save order details
            $order = Order::create([
                'user_id' => $request->user_id,
                'subtotal' => $request->subtotal,
                'grand_total' => $request->grand_total,
                'shipping' => $request->shipping,
                'discount' => $request->discount,
                'payment_status' => $request->payment_status,
                'name' => $request->name,
                'email' => $request->email,
                'status' => $request->status,
                'address' => $request->address,
                'mobile'=>$request->mobile,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
            ]);
    
            // Save order items
            foreach ($request->cart as $item) {
                $sizeRecord = Size::where('id', $item['size'])->first();
    
                // Ensure size exists before creating order item
                if (!$sizeRecord) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Size not found for product'
                    ], 400);
                }
    
                OrderItem::create([
                    'name'=>$item['title'],
                    'image'=>$item['imagePath'],
                    'order_id' => $order->id, // Link order to the item
                    'price' => $item['qty'] * $item['price'],
                    'unit_price' => $item['price'],
                    'qty' => $item['qty'],
                    'product_id' => $item['id'],
                    'size' => $sizeRecord->name,
                ]);
            }
    
            // Return success response
            return response()->json([
                'status' => 200,
                'order_id'=>$order->id,
                'message' => 'Order placed successfully'
            ], 200);
        } else {
            // If cart is empty, return error message
            return response()->json([
                'status' => 400,
                'message' => 'Cart is empty'
            ], 400);
        }
        }catch (\Exception $e) {
            // Agar koi error ho to catch block chalega
            Log::error("Order save failed: " . $e->getMessage());
    
            // Error response return karo
            return response()->json([
                'error' => 'Something went wrong. Please try again later.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function orderDetail(Request $request)
      {
         $order = Order::where('id', $request->id)
                  ->with('orderItems')
                  ->orderBy('created_at','DESC')
                  ->where('user_id', auth()->id()) // sirf logged in user ka order
                  ->first();

         if (!empty($order)) {
        return response()->json([
            'status' => 200,
            'data' => $order
        ], 200);
         } else {
        return response()->json([
            'status' => 404,
            'message' => 'Order not found or unauthorized'
        ], 404);
         }
    }
    public function customerOrders(){
         $order = Order::where('user_id', auth()->id())
                  ->with('orderItems')
                  ->orderBy('created_at','DESC')
                  ->get();
        if($order->isEmpty()){
            return response()->json([
                'status'=>404,
                'message'=>'No order found!'
            ],404);
        }
        else{
            return response()->json([
                'status'=>200,
                'data'=>$order
            ],200);
        }
    }

    
}
