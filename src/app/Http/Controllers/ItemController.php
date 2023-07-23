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
    $items=Item::with('categories')->get();
    return view('/index',compact('items'));
    }

    public function search(Request $request){
    //Itemテーブルから検索
    $ItemItems=Item::ItemSearch($request->name)->get();
    //Categoryテーブルから検索
    $categories=Category::CategorySearch($request->name)->get();
    //Categoryテーブルから検索されたレコードのitem_idを取得
    $categoriesItemIds=[];
    foreach($categories as $category){
    $categoriesItemIds[]=$category->item_id;
    }
    //取得したitem_idからItemテーブルを検索
    $categoriesItems=[];
    foreach($categoriesItemIds as $categoriesItemId){
    $categoriesItems[]=Item::findOrFail($categoriesItemId);
    }
    //Itemテーブルを検索して取得した配列をコレクションに変換
    $collection_categoriesItems = collect($categoriesItems);
    //ItemテーブルからのコレクションとCategoryテーブルからのコレクションを結合
    $newItems = collect($ItemItems)->merge($collection_categoriesItems);
    //結合したコレクションから重複データを削除
    $items = $newItems->unique('id');
    return view('/index',compact('items'));
    }

    public function detail($id){
    $item=Item::with('categories')->findOrFail($id);
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
