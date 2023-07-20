<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    
    public function favoriteStore(Request $request){
        $favorite=$request->only(['user_id','item_id']);
        Favorite::create($favorite);
        $item_id = request()->get('item_id');
        return response()->json(['item_id' => $item_id]);
    }

    public function favoriteDelete(Request $request){
        $user_id = request()->get('user_id');
        $item_id = request()->get('item_id');
        Favorite::where('user_id',$user_id)->where('item_id',$item_id)->delete();
        return response()->json(['item_id' => $item_id]);
    }
}
