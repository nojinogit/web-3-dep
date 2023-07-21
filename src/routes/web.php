<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;

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

//Route::get('/', function () {return view('welcome');});

Route::get('/',[ItemController::class,'index'])->name('index');
Route::get('/detail/{id}',[ItemController::class,'detail'])->name('detail');
Route::get('/myList/{id}',[ItemController::class,'myList'])->name('myList');
Route::post('/favoriteStore',[FavoriteController::class,'favoriteStore'])->name('favoriteStore');
Route::delete('/favoriteDelete',[FavoriteController::class,'favoriteDelete'])->name('favoriteDelete');
Route::get('/comment/{id}', [CommentController::class,'comment'])->name('comment');
Route::post('/commentAdd', [CommentController::class,'commentAdd'])->name('commentAdd');


Route::get('/login', function () {return view('/login');});
Route::get('/register', function () {return view('/auth/register');});
Route::get('/purchase', function () {return view('/purchase');});
Route::get('/address', function () {return view('/address');});
Route::get('/myPage', function () {return view('/myPage');});
Route::get('/profile', function () {return view('/profile');});
Route::get('/sell', function () {return view('/sell');});