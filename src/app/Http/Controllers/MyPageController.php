<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\ProfileRequest;

class MyPageController extends Controller
{
    public function myPage(Request $request){
    $items=Item::with('user','purchases')->where('user_id',Auth::user()->id)->get();
    $user=User::findOrFail(Auth::user()->id);
    return view('/myPage',compact('items','user'));
    }

    public function myPagePurchase(Request $request){
    $purchases=Purchase::where('user_id',Auth::user()->id)->get();
    $itemIds=[];
    foreach($purchases as $purchase){
        $itemIds[]=$purchase->item_id;
    };
    $items=[];
    foreach($itemIds as $itemId){
        $items[]=Item::with('categories')->findOrFail($itemId);
    };
    $user=User::findOrFail(Auth::user()->id);
    return view('/myPage',compact('items','user'));
    }

    public function profile(Request $request){
    $user=User::findOrFail(Auth::user()->id);
    return view('/profile',compact('user'));
    }

    public function profileUpdate(ProfileRequest $request){
    if($request->file('image')!==null){
        $dir='sample';
        $image_name=$request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/'.$dir,$image_name);
        $user=['path' => 'storage/'.$dir.'/'.$image_name];
        }

    if($request->name!==null){
    $user['name']=$request->name;}

    $user['postcode']=$request->postcode;

    $user['address']=$request->address;

    $user +=array('building'=>$request->building);

    User::findOrFail(Auth::user()->id)->update($user);
    return redirect('/myPage/profile')->with('key','登録が完了しました');
    }
}
