<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Favorite;

class ItemController extends Controller
{
    public function index(Request $request){
    $items=Item::with('categories')->get();
    return view('/index',compact('items'));
    }

    public function detail($id){
    $item=Item::with('categories')->findOrFail($id);
    return view('/detail',compact('item'));
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
