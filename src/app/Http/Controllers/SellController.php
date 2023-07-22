<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class SellController extends Controller
{
    public function sell(Request $request){
    return view('/sell');
    }

    public function exhibit(Request $request){
        $dir='sample';
        $image_name=$request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/'.$dir,$image_name);
    $item=$request->only(['user_id','name','brand','condition','explanation','price']);
    $item['path']='storage/'.$dir.'/'.$image_name;
    $item=Item::create($item);
    $category=$request->only(['category']);
    $category['item_id']=$item->id;
    Category::create($category);
    return redirect('/myPage');
    }
}
