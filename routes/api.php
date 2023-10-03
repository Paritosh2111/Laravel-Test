<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/list',[UserController::class,'index']);
Route::post('/save',[UserController::class,'save'])->name('save.data');
Route::post('/update',[UserController::class,'update'])->name('update.data');
Route::get('/edit/{id}',[UserController::class,'edit'])->name('user.edit');
Route::delete('/delete/{id}',[UserController::class,'delete'])->name('user.delete');
Route::get('/search',[UserController::class,'search'])->name('user.search');



// collection :
https://api.postman.com/collections/29463636-2361ebf0-aca7-4edd-a133-d87f8bf60de5?access_key=
