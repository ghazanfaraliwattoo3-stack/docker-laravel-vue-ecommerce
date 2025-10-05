<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
class BrandController extends Controller
{
    // this function returns all brands
    public function index(){
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
    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required|unique:brands'
        ]);
        if($validator->fails()){
            return response()->json([
                "status"=>400,
                "errors"=>$validator->errors()
            ],400);
        }
        $brand=Brand::create([
            "name"=>$request->name
        ]);
        return response()->json([
            "status"=>200,
            "message"=>"Brand added successfully",
            "data"=>$brand,
        ]);
        
    }
    public function show($id){
        $brand=Brand::find($id);
        if(!$brand){
             return response()->json([
                'status'=>404,
                'message'=>'brand not found'
             ],404);
        }
        return response()->json([
            'status'=>200,
            'data'=>$brand
        ],200);
    }
    public function update(Request $request,$id){
        $validator=Validator::make($request->all(),[
            'name'=>'nullable|unique:brands,name,'.$id
        ]);
        if($validator->fails()){
            return response()->json([
                "status"=>400,
                "errors"=>$validator->errors()
            ],400);
        }
          $brand=Brand::find($id);
          if(!$brand){
            return response()->json([
                "status"=>404,
                "message"=>"Brand not found"
            ],404);
          }
          
          $isUpdate=$brand->update([
            'name'=>$request->name??$brand->name,
            'status'=>$request->status??$brand->name
          ]);
          $update_brand=Brand::find($id);
          if($isUpdate){
            return response()->json([
                'status'=>200,
                'message'=>'brand updated successfully',
                'data'=>$update_brand
            ]);
          }
          return response()->json([
            "status" => 500,
            "message" => "Failed to update brand"
        ], 500);
    }
    public function destroy($id){
       $brand=Brand::find($id);
       if(!$brand){
        return response()->json([
            'status'=>404,
            'message'=>'brand not found'
        ],404);
       }
       $brand->delete();
       return response()->json([
        'status'=>200,
        'message'=>'brand delete successfully'
       ],200);
    }
}
