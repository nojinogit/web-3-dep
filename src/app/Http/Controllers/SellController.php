<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\SellRequest;
use Illuminate\Support\Facades\DB;

class SellController extends Controller
{
    public function sell(Request $request){
    return view('/sell');
    }

    public function exhibit(SellRequest $request){
    DB::transaction(function () use ($request) {
        $image_name=$request->file('image')->getClientOriginalName();
        $path=Storage::disk('s3')->putFile('sample', $request->file('image'));
        $item=$request->only(['user_id','name','brand','condition','explanation','price','path' => Storage::disk('s3')->url($path)]);
        $item=Item::create($item);
        $categories = $request->input('category');
        foreach ($categories as $category) {
            Category::create(['item_id'=>$item->id,'category' => $category]);
        }
    });
    return redirect('/myPage');
    }


    public function withdraw($id){

    Item::find($id)->delete();

    return redirect('/myPage');
    }
}
