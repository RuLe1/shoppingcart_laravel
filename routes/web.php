<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Livewire\CartComponent;
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
    return view('home');
});
Route::get('/',[ProductController::class,'show_product'])->name('home');
Route::post('/add-cart-ajax',[ProductController::class,'add_cart_ajax']);
Route::get('/delete-product/{session_id}',[ProductController::class,'delete_product']);
Route::post('/update-cart-ajax',[ProductController::class,'update_cart_ajax']);


