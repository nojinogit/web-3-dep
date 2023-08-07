<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\Category;


class ItemController extends Controller
{
    public function index(Request $request){
    $items=Item::with('categories','purchases')->get();
    return view('/index',compact('items'));
    }

    public function search(Request $request){
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
