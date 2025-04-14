<?php

use App\Http\Controllers\Authentication;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Homecontroller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/home',function(){
  return view('dashboard.home');
});
Route::get('/register/account',[Authentication::class,"register"]);
Route::post('/submit/register',[Authentication::class,'submitRegister']);

Route::get('/signin',[Authentication::class,"login"])->name('login');
Route::post('/submit/login',[Authentication::class,'submitLogin']);

Route::get('/',[Homecontroller::class,'Home'])->middleware('auth');

Route::get('/logout',[Authentication::class,'logout'])->middleware('auth');
Route::post('/submit/logout',[Authentication::class,'submitLogout']);

Route::get('/add/logo',[Homecontroller::class,'logo'])->middleware('auth');
Route::post('/submit/add-logo',[Homecontroller::class,'submitAddLogo'])->middleware('auth');
Route::get('/list-logo',[Homecontroller::class,"listLogo"])->middleware('auth')->name('list-logo');
Route::get('/update/logo/{id}',[Homecontroller::class,'updateLogo'])->middleware('auth');
Route::post('/submit/update-logo/',[Homecontroller::class,'submitUpdateLogo'])->middleware('auth');
Route::post('/remove/logo/{id}',[Homecontroller::class,'destroy'])->middleware('auth')->name('Logo.remove');

Route::get('/add/category/',[Homecontroller::class,'category']);
Route::post('/submit/addcategory/',[Homecontroller::class,'addCategory']);
Route::get('/list/category/',[Homecontroller::class,'listCategory'])->middleware('auth')->name('list-category');
Route::get("/update/category/{id}",[Homecontroller::class,'updateCategory'])->middleware('auth')->name('Category.update');
Route::post('/submit/updateCategory/',[Homecontroller::class,'submitUpdateCategory'])->middleware('auth');
Route::post('/remove/category/{id}',[Homecontroller::class,'destroyCategory'])->middleware('auth')->name('category.remove');

Route::get('/list/product/',[Homecontroller::class,'product'])->middleware('auth')->name('list');
Route::get('/add/product/',[Homecontroller::class,'addProduct'])->middleware('auth');
Route::post('/submit/add-product/',[Homecontroller::class,'submitAddProduct']);
Route::get('/update/product/{id}',[Homecontroller::class,'updateProduct'])->middleware('auth');
Route::post('/submit/updateProduct/',[Homecontroller::class,'submitUpdateProduct'])->middleware('auth');
Route::post('/remove/post/{id}',[Homecontroller::class,'destroyProduct'])->middleware('auth')->name('product.remove');

Route::get('/add/news/',[Homecontroller::class,'news'])->middleware('auth');
Route::post('/submit/add-news/',[Homecontroller::class,'submitAddNews'])->middleware('auth');
Route::get('/list/news/',[Homecontroller::class,'listNews'])->middleware('auth')->name('list-news');
Route::get('/update/news/{id}',[Homecontroller::class,'updateNews'])->middleware('auth');
Route::post('/submit/updateNews/',[Homecontroller::class,'submitUpdateNews'])->middleware('auth')->name('news.update');
Route::post('/remove/news/{id}',[Homecontroller::class,'destroyNews'])->middleware('auth')->name('news.remove');



