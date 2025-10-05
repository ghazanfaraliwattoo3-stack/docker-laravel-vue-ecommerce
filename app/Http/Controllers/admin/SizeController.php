<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
class SizeController extends Controller
{
    // this function will return all sizes
    public function index(){
           $size=Size::orderBy('name','ASC')->get();
           return response()->json([
             'status'=>200,
             'data'=>$size
           ],200);
    }
}
