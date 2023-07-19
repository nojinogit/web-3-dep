<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request){
    $items=Item::with('categories')->get();
    return view('/index',compact('items'));
    }

    public function detail($id){
    $item=Item::find($id);
    return view('/detail',compact('item'));
    }
}
