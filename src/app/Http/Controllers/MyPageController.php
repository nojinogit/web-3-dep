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
        $image_name=$request->file('image')->getClientOriginalName();
        $path=Storage::disk('s3')->putFile('sample', $request->file('image'));
        $user=['path' => Storage::disk('s3')->url($path)];
        }

    if($request->name!==null){
    $user['name']=$request->name;}

    $user['postcode']=$request->postcode;

    $user['address']=$request->address;

    $user +=array('building'=>$request->building);

    User::findOrFail(Auth::user()->id)->update($user);
    return redirect('/myPage/profile')->with('key','登録が完了しました');
    }

    public function bankNumber(Request $request){
    $user=User::findOrFail(Auth::user()->id);
    return view('/bankNumber',compact('user'));
    }

    public function bankNumberUpdate(Request $request){

    $user['bank']=$request->bank;

    $user['bank_branch']=$request->bank_branch;

    $user['bank_type']=$request->bank_type;

    $user['bank_number']=$request->bank_number;

    User::findOrFail(Auth::user()->id)->update($user);
    return redirect('/myPage/bankNumber')->with('key','登録が完了しました');
    }

}
