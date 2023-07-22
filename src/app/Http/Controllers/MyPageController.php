<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;

class MyPageController extends Controller
{
    public function myPage(Request $request){
    $items=Item::with('user')->where('user_id',Auth::user()->id)->get();
    $user=User::findOrFail(Auth::user()->id);
    return view('/myPage',compact('items','user'));
    }

    public function profile(Request $request){
    $user=User::findOrFail(Auth::user()->id);
    return view('/profile',compact('user'));
    }

    public function profileUpdate(Request $request){
    if($request->file('image')!==null){
        $dir='sample';
        $image_name=$request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/'.$dir,$image_name);
        $user=['path' => 'storage/'.$dir.'/'.$image_name];
        }

    if($request->name!==null){
    $user['name']=$request->name;}

    if($request->postcode!==null){
    $user['postcode']=$request->postcode;}

    if($request->address!==null){
    $user['address']=$request->address;}

    if($request->building!==null){
    $user +=array('building'=>$request->building);}

    User::findOrFail(Auth::user()->id)->update($user);
    return redirect('/myPage/profile');
    }
}
