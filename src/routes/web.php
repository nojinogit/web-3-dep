<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StripeController;

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

Route::get('/login', function () {return view('/login');})->name('login');
Route::get('/register', function () {return view('/auth/register');})->name('register');
Route::get('/',[ItemController::class,'index'])->name('index');
Route::get('/search',[ItemController::class,'search'])->name('search');
Route::get('/detail/{id}',[ItemController::class,'detail'])->name('detail');
Route::get('/comment/{id}', [CommentController::class,'comment'])->name('comment');
Route::get('/stripe',[StripeController::class,'stripe'])->name('stripe');

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/myList/{id}',[ItemController::class,'myList'])->name('myList');
    Route::post('/favoriteStore',[FavoriteController::class,'favoriteStore'])->name('favoriteStore');
    Route::delete('/favoriteDelete',[FavoriteController::class,'favoriteDelete'])->name('favoriteDelete');
    Route::post('/commentAdd', [CommentController::class,'commentAdd'])->name('commentAdd');
    Route::delete('/commentDelete', [CommentController::class,'commentDelete'])->name('commentDelete');
    Route::get('/myPage', [MyPageController::class,'myPage'])->name('myPage');
    Route::get('/myPage/purchase', [MyPageController::class,'myPagePurchase'])->name('myPagePurchase');
    Route::get('/myPage/profile', [MyPageController::class,'profile'])->name('profile');
    Route::put('/myPage/profile', [MyPageController::class,'profileUpdate'])->name('profileUpdate');
    Route::get('/sell', [SellController::class,'sell'])->name('sell');
    Route::post('/exhibit', [SellController::class,'exhibit'])->name('exhibit');
    Route::get('/purchase/{id}', [PurchaseController::class,'purchase'])->name('purchase');
    Route::post('/purchase', [PurchaseController::class,'confirm'])->name('confirm');
    Route::get('/purchase/address/{id}', [PurchaseController::class,'address'])->name('address');
    Route::post('/purchase/address', [PurchaseController::class,'addressChange'])->name('addressChange');
});



