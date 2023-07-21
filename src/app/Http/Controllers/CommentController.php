<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;


class CommentController extends Controller
{
    public function comment($id){
    $item=Item::with('user','comments')->findOrFail($id);
    return view('/comment',compact('item'));
    }

    public function commentAdd(Request $request){
    $comment=$request->only(['user_id','item_id','comment']);
    Comment::create($comment);
    return redirect(route('comment',['id' => $request->item_id]));
    }
}
