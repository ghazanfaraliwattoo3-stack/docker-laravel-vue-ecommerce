<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;

class ShippingController extends Controller
{
    // Get first shipping record
    public function index()
    {
        $shipping = Shipping::first();

        return response()->json([
            'status' => 200,
            'data' => $shipping,
        ]);
    }

    // Create or update shipping address
    public function storeOrCreate(Request $request)
    {
        // $request->validate([
        //     'shipping' => 'required|string',
        // ]);

        $shipping = Shipping::first();

        if ($shipping) {
            $shipping->shipping = $request->shipping;
            $shipping->save();
        } else {
            Shipping::create([
                'shipping' => $request->shipping,
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Shipping address saved successfully.',
        ]);
    }
}
