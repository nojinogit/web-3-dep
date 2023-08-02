<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\SellRequest;

class SellController extends Controller
{
    public function sell(Request $request){
    return view('/sell');
    }

    public function exhibit(SellRequest $request){
        $dir='sample';
        $image_name=$request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/'.$dir,$image_name);
    $item=$request->only(['user_id','name','brand','condition','explanation','price']);
    $item['path']='storage/'.$dir.'/'.$image_name;
    $item=Item::create($item);
    $categories = $request->input('category');
    foreach ($categories as $category) {
        Category::create(['item_id'=>$item->id,'category' => $category]);
    }
    return redirect('/myPage');
    }
}
