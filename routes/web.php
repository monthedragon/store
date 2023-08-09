<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductController;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function(){

    //limiter can be adjusted
    Route::middleware('throttle:100,1')->group(function(){ 
        Route::get('/product', [ProductController::class,'index'])->name('product');
        Route::post('/product', [ProductController::class,'index'])->name('product'); //search product
    });
    
    Route::middleware('can:isAdmin')->group(function(){
        //admin
        Route::get('/product/create',[ProductController::class,'create']); 
        Route::post('/product/store',[ProductController::class,'store']); 
        Route::get('/product/{product}',[ProductController::class,'edit']); 
        Route::patch('/product/{product}',[ProductController::class,'update']); 
        Route::delete('/product/{product}',[ProductController::class,'destroy']); 
        Route::patch('/order/cancel/{order}',[OrderController::class,'cancel']);
        Route::patch('/order/ship/{order}',[OrderController::class,'ship']);
        Route::patch('/order/checkout/{order}',[OrderController::class,'checkOut']);
        
    });
    
    //special limiter for adding orders
    Route::post('/add_to_cart/{product}',[OrderController::class,'store'])->middleware('throttle:20,1');
    
    //limiter can be adjusted
    Route::middleware('throttle:100,1')->group(function(){
        Route::get('/order', [OrderController::class, 'index'])->name('order');
        Route::get('/order/{order}', [OrderController::class, 'show']);
        Route::delete('/order_detail/remove/{orderDetail}', [OrderDetailController::class, 'destroy']);
    });

    

});