<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Access;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{
    public function index(Request $request){
    $uniqueItems = Item::with('categories', 'purchases')->get();
    $items = $uniqueItems->reject(function ($item) {
            foreach ($item->purchases as $purchase) {
                if ($purchase->payment != null) {
                    return true;
                }
            }
            return false;
            });
    return view('/index', compact('items'));
    }

    public function recommendation(Request $request){
    if (Auth::check()) {
        $accesses = Access::with('item.categories')->where('user_id', Auth::user()->id)->first();
        if ($accesses) {
            $categories = [];
            foreach ($accesses->item->categories as $category) {
                $searchResults = Category::CategorySearch($category->category)->get();
                foreach ($searchResults as $searchResult) {
                    $categories[] = $searchResult;
                }
            }
            $categoriesItemIds = [];
            foreach ($categories as $category) {
                $categoriesItemIds[] = $category->item_id;
            }
            $categoriesItems = [];
            foreach ($categoriesItemIds as $categoriesItemId) {
                $categoriesItems[] = Item::with('purchases')->findOrFail($categoriesItemId);
            }
            $collection_categoriesItems = collect($categoriesItems);
            $uniqueItems = $collection_categoriesItems->unique('id');
            $items = $uniqueItems->reject(function ($item) {
            foreach ($item->purchases as $purchase) {
                if ($purchase->payment != null) {
                    return true;
                }
            }
            return false;
            });
            return view('/index', compact('items'))->with('recommendations','あなたへのおすすめ商品');
        }
    }
    $uniqueItems = Item::with('categories', 'purchases')->get();
    $items = $uniqueItems->reject(function ($item) {
    foreach ($item->purchases as $purchase) {
        if ($purchase->payment != null) {
            return true;
        }
    }
    return false;
    });
    return view('/index', compact('items'));
    }

    public function search(Request $request){
    $ItemItems=Item::with('purchases')->ItemSearch($request->name)->get();
    $categories=Category::CategorySearch($request->name)->get();
    $categoriesItemIds=[];
    foreach($categories as $category){
    $categoriesItemIds[]=$category->item_id;
    }
    $categoriesItems=[];
    foreach($categoriesItemIds as $categoriesItemId){
    $categoriesItems[]=Item::with('purchases')->findOrFail($categoriesItemId);
    }
    $collection_categoriesItems = collect($categoriesItems);
    $newItems = collect($ItemItems)->merge($collection_categoriesItems);
    $uniqueItems = $newItems->unique('id');
    $items = $uniqueItems->reject(function ($item) {
    foreach ($item->purchases as $purchase) {
        if ($purchase->payment != null) {
            return true;
        }
    }
    return false;
    });
    return view('/index',compact('items'));
    }

    public function searchAll(Request $request){
    $ItemItems=Item::ItemSearch($request->name)->get();
    $categories=Category::CategorySearch($request->name)->get();
    $categoriesItemIds=[];
    foreach($categories as $category){
    $categoriesItemIds[]=$category->item_id;
    }
    $categoriesItems=[];
    foreach($categoriesItemIds as $categoriesItemId){
    $categoriesItems[]=Item::findOrFail($categoriesItemId);
    }
    $collection_categoriesItems = collect($categoriesItems);
    $newItems = collect($ItemItems)->merge($collection_categoriesItems);
    $items = $newItems->unique('id');
    return view('/index',compact('items'));
    }

    public function detail($id){
    if(Auth::check()){
        $access=Access::with('item.categories')->where('user_id',Auth::user()->id)->first();
        if($access){
            $access->update(['item_id'=>$id]);
        } else{
            Access::create(['user_id'=>Auth::user()->id,'item_id'=>$id]);
        }
    }
    $item=Item::with('categories','purchases')->findOrFail($id);
    $favoriteCount=Favorite::where('item_id',$id)->count();
    $commentCount=Comment::where('item_id',$id)->count();
    return view('/detail',compact('item','favoriteCount','commentCount'));
    }

    public function myList($id){
    $favoriteItems=Favorite::where('user_id',$id)->get();
    $itemIds=[];
    foreach($favoriteItems as $favoriteItem){
        $itemIds[]=$favoriteItem->item_id;
    };
    $items=[];
    foreach($itemIds as $itemId){
        $items[]=Item::with('categories')->findOrFail($itemId);
    };
    return view('/index',compact('items'));
    }
}
