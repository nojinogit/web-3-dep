<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Favorite;


class CommentController extends Controller
{
    public function comment($id){
    $item=Item::with('user','comments')->findOrFail($id);
    $comments=Comment::with('user')->orderBy('updated_at', 'desc')->where('item_id',$id)->Paginate(3);
    $favoriteCount=Favorite::where('item_id',$id)->count();
    $commentCount=Comment::where('item_id',$id)->count();
    return view('/comment',compact('item','comments','favoriteCount','commentCount'));
    }

    public function commentAdd(Request $request){
    $comment=$request->only(['user_id','item_id','comment']);
    Comment::create($comment);
    return redirect(route('comment',['id' => $request->item_id]));
    }

    public function commentDelete(Request $request){
    Comment::findOrFail($request->id)->delete();
    return redirect(route('comment',['id' => $request->item_id]));
    }
}
