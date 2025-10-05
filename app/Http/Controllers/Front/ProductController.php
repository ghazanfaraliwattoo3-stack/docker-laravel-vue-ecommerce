<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
class ProductController extends Controller
{
    public function latestProduct(){
        $latestProduct = Product::where('status', 1)
        ->orderBy('created_at', 'DESC')
        ->limit(8)
        ->get();
        return response()->json([
            'data'=>$latestProduct
        ]);
    }
    public function featuredProduct(){
        $featuredProduct = Product::where('is_featured', 'yes')
        ->orderBy('created_at', 'DESC')
        ->limit(8)
        ->get();
        return response()->json([
            'data'=>$featuredProduct
        ]);
    }
    public function getProducts(){
        $products = Product::orderBy('created_at', 'DESC')->with('sizes')->get();
       
        return response()->json([
            'status'=>200,
            'data'=>$products
        ],200);
    }
    public function getBrands(){
        $brand=Brand::latest()->get();
        if($brand->isEmpty()){
            return response()->json([
                "status"=>404,
                "message"=>"Brand no found",
                "data"=>[]
            ],404);
        }
        return response()->json([
            "status"=>200,
            "data"=>$brand
        ],200);
     }
    public function getCategories(){
    
    $category=Category::latest()->get();
    if($category->isEmpty()){
        return response()->json([
            'status'=>404,
            'message'=>'Category not found',
            'data'=>[]
        ],404);
    }
    return response()->json([
        'status'=>200,
        'data'=>$category
    ]);
    }
    public function getProduct($id){
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
    public function getProductImage($id){
        $product=Product::where('id',$id)->first();
        return response()->json([
          'status'=>200,
          'data'=>$product->image,
        ],200);
    }
    public function filterProducts(Request $request)
{
    $product = Product::query();

    // Category filter (string or array)
    if ($request->categoryId) {
        if (is_array($request->categoryId)) {
            $product->whereIn('category_id', $request->categoryId);
        } else {
            $product->where('category_id', $request->categoryId);
        }
    }

    // Brand filter (string or array)
    if ($request->brandId) {
        if (is_array($request->brandId)) {
            $product->whereIn('brand_id', $request->brandId);
        } else {
            $product->where('brand_id', $request->brandId);
        }
    }

    $products = $product->latest()->get();

    if ($products->isEmpty()) {
        return response()->json([
            'status' => 404,
            'message' => "Product not found"
        ], 404);
    } else {
        return response()->json([
            'status' => 200,
            'data' => $products
        ], 200);
    }
}

}

