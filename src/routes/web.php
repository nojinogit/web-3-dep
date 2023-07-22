<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\SellController;

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
Route::delete('/commentDelete', [CommentController::class,'commentDelete'])->name('commentDelete');
Route::get('/myPage', [MyPageController::class,'myPage'])->name('myPage');
Route::get('/myPage/profile', [MyPageController::class,'profile'])->name('profile');
Route::put('/myPage/profile', [MyPageController::class,'profileUpdate'])->name('profileUpdate');
Route::get('/sell', [SellController::class,'sell'])->name('sell');
Route::post('/exhibit', [SellController::class,'exhibit'])->name('exhibit');

Route::get('/login', function () {return view('/login');});
Route::get('/register', function () {return view('/auth/register');});
Route::get('/purchase', function () {return view('/purchase');});
Route::get('/address', function () {return view('/address');});
