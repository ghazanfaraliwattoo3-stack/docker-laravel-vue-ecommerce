<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{
    // this function will return all categories
    public function index(){
    
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
    // this function will store data into db
    public function store(Request $request){
        $validator=Validator::make($request->all(),[
                 'name'=>'required|unique:categories'
        ]);  
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()
            ],400);
        }
        $category=Category::create([
            'name'=>$request->name,
            'status'=>$request->status
        ]);
        return response()->json([
            'status'=>200,
            'message'=>'Category added successfully',
            'data'=>$category
        ],200);
        
      
    }
    // this function will show single category
    public function show($id){
        
        $category=Category::find($id);
        if(!$category){
            return response()->json([
                'status'=>404,
                'message'=>'Category not found',
            ],404);
        }
        return response()->json([
            'status'=>200,
            'data'=>$category
        ],200);
    }
    // this function will update category
    public function update(Request $request, $id) {
        
        $category = Category::find($id);
    
        if (!$category) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found'
            ], 404);
        }
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,'.$id,
            'status' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }
    
        $updated = $category->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
    
        if ($updated) {
            return response()->json([
                'status' => 200,
                'message' => 'Category updated successfully',
                'data' => $category
            ], 200);
        }
    
        return response()->json([
            'status' => 500,
            'message' => 'Something went wrong'
        ], 500);
    }
    
    
    
    public function destroy($id){
        $category=Category::find($id);
         if(!$category){
            return response()->json([
                'status'=>404,
                'message'=>'product not found'
            ]);
         }
         $category->delete();
         return response()->json([
            'status'=>200,
            'message'=>'Category delete successfully'
        ],200);
    }
}
