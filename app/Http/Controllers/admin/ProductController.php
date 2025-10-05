<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Product;
use App\Models\TempImage;

class ProductController extends Controller
{
    // this method will retun all products
    public function index(){
        $products = Product::orderBy('created_at', 'DESC')->with('sizes')->get();
       
        return response()->json([
            'status'=>200,
            'data'=>$products
        ],200);
    }
    // this method will store a new products
    public function store(Request $request){
        // validate the request
        $validator=Validator::make($request->all(),[
            'title'=>'required',
            'price'=>'required|numeric',
            'category_id'=>'required|numeric',
            'status'=>'required|integer',
            'sku'=>'required|unique:products,sku',
            'is_featured'=>'required',
        ],[
            'category_id.required'=>'The category field is required.',
            'category_id.numeric    '=>'The category must be a number',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors(),
            ],400);
        }
        // add image in product table
        $tempImage=null;
    
         if($request->image){
            $tempImage=TempImage::find($request->image);
            // large image
            $manager = new ImageManager(new Driver());
            $imageInstance = $manager->read('uploads/temp/'.$tempImage->name);
            $imageInstance->scaleDown(1200);
            $imageInstance->save('uploads/products/large/'.$tempImage->name);
            // small image
            $manager = new ImageManager(new Driver());
            $imageInstance = $manager->read('uploads/temp/'.$tempImage->name);
            $imageInstance->coverDown(400,460);
            $imageInstance->save('uploads/products/small/'.$tempImage->name);
            $tempImagePath = public_path('uploads/temp/' . $tempImage->name);
            if (file_exists($tempImagePath)) {
                unlink($tempImagePath); // Deletes the file from the temp directory
            }
    
            // After processing the image, remove the entry from the TempImage table
            $tempImage->delete();
    
         }
        // store the product
        $product=Product::create([
            'title'=>$request->title,
            'price'=>$request->price,
            'compare_price'=>$request->compare_price,
            'category_id'=>$request->category_id,
            'brand_id'=>$request->brand_id,
            'qty'=>$request->qty,
            'sku'=>$request->sku, 
            'barcode'=>$request->barcode,
            'short_description'=>$request->short_description,
            'description'=>$request->description,
            'status'=>$request->status,
            'is_featured'=>$request->is_featured,
            'image'=>$tempImage ? $tempImage->name : null
        ]);
        $product->sizes()->attach($request->sizes);

        return response()->json([
           'status'=>200,
           'message'=>'Product has been created successfully',
        ],200);
    }
    // this method will retun a single products
    public function show($id){
        $product = Product::with('sizes')->find($id);
        if($product == null){
            return response()->json([
                'status'=>404,
                'message'=>"Product not found"
            ],404);
        }
        return response()->json([
            'status'=>200,
            'data'=>$product,
        ],200);
    }
    // this method will update a products
    public function update(Request $request,$id){
        // validate the request
        $validator=Validator::make($request->all(),[
            'title'=>'nullable',
            'price'=>'nullable|numeric',
            'category_id'=>'nullable|numeric',
            'status'=>'nullable|integer',
            'sku'=>"nullable|unique:products,sku,$id",
            'is_featured'=>'nullable',
        ],[
            'category_id.numeric    '=>'The category must be a number',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors(),
            ],400);
        }
        // add image in product table
        $product=Product::find($id);
        

        $tempImage=null;
    
         if($request->image){
            $tempImage=TempImage::find($request->image);
            // large image
            $manager = new ImageManager(new Driver());
            $imageInstance = $manager->read('uploads/temp/'.$tempImage->name);
            $imageInstance->scaleDown(1200);
            $imageInstance->save('uploads/products/large/'.$tempImage->name);
            // small image
            $manager = new ImageManager(new Driver());
            $imageInstance = $manager->read('uploads/temp/'.$tempImage->name);
            $imageInstance->coverDown(400,460);
            $imageInstance->save('uploads/products/small/'.$tempImage->name);
            $tempImagePath = public_path('uploads/temp/' . $tempImage->name);
            if (file_exists($tempImagePath)) {
                unlink($tempImagePath); // Deletes the file from the temp directory
            }
    
            // After processing the image, remove the entry from the TempImage table
            $tempImage->delete();
    
         }
        // store the product
        $product->update([
            'title'=>$request->title,
            'price'=>$request->price,
            'compare_price'=>$request->compare_price,
            'category_id'=>$request->category_id,
            'brand_id'=>$request->brand_id,
            'qty'=>$request->qty,
            'sku'=>$request->sku, 
            'barcode'=>$request->barcode,
            'short_description'=>$request->short_description,
            'description'=>$request->description,
            'status'=>$request->status,
            'is_featured'=>$request->is_featured,
            'image'=>$tempImage ? $tempImage->name : $product->image
        ]);
        $product->sizes()->sync($request->sizes);
        return response()->json([
           'status'=>200,
           'message'=>'Product has been updated successfully',
        ],200);
    }
    // this method will delete a products
    public function destroy($id){
        $product=Product::find($id);
        if($product == null){
            return response()->json([
                  'status'=>404,
                  'message'=>"Product not found",
            ],404);
        }
        $is_delete=$product->delete();
        if($is_delete){
            return response()->json([
                'status'=>200,
                'message'=>"Product has been deleted successfully",
          ],200);
        }else{
            return response()->json([
                'status'=>500,
                'message'=>"Failed to delete the product. Please try again.",
          ],500);
        }
    }
}
