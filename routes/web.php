<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\admin\CategoryController;

Route::get('/testt',function(){
    return view('test');
});
Route::post('/test/store',[TestController::class,'store'])->name('store');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any','.*');
