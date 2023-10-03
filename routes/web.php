<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });


// User Create Routes

Route::get('/',[UserController::class,'index']);
Route::get('/dynamic-div',[UserController::class,'load_data'])->name('exp.load');
Route::get('/editdynamic-div',[UserController::class,'edit_load_data'])->name('edit_exp.load');
Route::post('/save',[UserController::class,'save'])->name('save.data');
Route::post('/update',[UserController::class,'update'])->name('update.data');
Route::get('/reload',[UserController::class,'reloadData'])->name('user.reload');
Route::get('/edit/{id}',[UserController::class,'edit'])->name('user.edit');
Route::delete('/delete/{id}',[UserController::class,'delete'])->name('user.delete');
Route::get('/search',[UserController::class,'search'])->name('user.search');


// User Crud Table Routes

