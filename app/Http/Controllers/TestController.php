<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TempImage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TestController extends Controller
{
    public function store(Request $request)
    {

        try{
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
                
            $image = $request->file('image');
            $imgName = time() . '.' . $image->getClientOriginalExtension();
    
            $uploadPath = public_path('uploads/temp/');
            $thumbPath = public_path('uploads/temp/thumb/');
    
            $image->move($uploadPath, $imgName);
            $data=TempImage::create([
               'name'=>$imgName
            ]);
    
    
            
            $manager = new ImageManager(new Driver());
            $imageInstance = $manager->read($uploadPath.$imgName);
    
            $imageInstance->coverDown(400, 450);
    
            $imageInstance->save($thumbPath . $imgName);
    
            return response()->json([
                'status' => 200,
                'message' => 'Image uploaded successfully!',
                'image_url' => url('uploads/temp/' . $imgName),
                'thumbnail_url' => url('uploads/temp/thumb/' . $imgName),
                'data'=>$data,
            ]);
        }catch(\Examption $e){
                   return response()->json([
                    'errors'=>$e->getMessage()
                   ]);
        }
    }
}

