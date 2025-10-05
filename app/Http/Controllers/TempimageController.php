<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\TempImage;
use Illuminate\Support\Facades\Validator;

class TempimageController extends Controller
{
    public function index()
    {
        $productImage = TempImage::all();
        return response()->json([
            'data' => $productImage
        ]);
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>200,
                'errors'=>$validator->errors()
            ],200);
        }

        $image = $request->file('image');
        $imgName = time() . '.' . $image->getClientOriginalExtension();

        $uploadPath = public_path('uploads/temp/');
        $thumbPath = public_path('uploads/temp/thumb/');

        $image->move($uploadPath, $imgName);
        
        $data=TempImage::create([
           'name'=>$imgName
        ]);



        return response()->json([
            'status' => 200,
            'message' => 'Image uploaded successfully!',
            'data'=>$data,
        ]);
    }
}
