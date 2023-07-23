<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function purchase($id){
    $item=Item::findOrFail($id);
    $user=User::findOrFail(Auth::user()->id);
    return view('/purchase',compact('item','user'));
    }

    public function address($id){
    $item=Item::findOrFail($id);
    $user=User::findOrFail(Auth::user()->id);
    return view('/address',compact('item','user'));
    }

    public function addressChange(Request $request){
    $item=Item::findOrFail($request->item_id);
    $user=User::findOrFail($request->user_id);
    $user['postcode']=$request->postcode;
    $user['address']=$request->address;
    $user['building']=$request->building;
    return view('/purchase',compact('item','user'));
    }

    public function confirm(Request $request){
    $purchase=$request->only(['user_id','item_id','postcode','address','building','payment']);
    Purchase::create($purchase);
    return redirect('/myPage/purchase');
    }
}
