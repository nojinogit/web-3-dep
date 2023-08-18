<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Mail\ContactMail;
use Illuminate\Contracts\Mail\Mailer;


class ManagementController extends Controller
{
    public function management(Request $request){

    return  view('/management');
    }

    public function account(Request $request){

    $accounts=User::NameSearch($request->name)->EmailSearch($request->email)->RoleSearch($request->role)->get();
    return view('/management',compact('accounts'));
    }

    public function accountDelete(Request $request){

    User::find($request->id)->delete();
    return redirect('/management');
    }

    public function accountRole(Request $request){

    User::findOrFail($request->id)->update(['role'=>100]);
    return redirect('/management');
    }

    public function accountRoleDelete(Request $request){

    User::findOrFail($request->id)->update(['role'=>1]);
    return redirect('/management');
    }

    public function contactMail(Request $request,Mailer $mailer){

    $title=$request->title;
    $main=$request->main;
    $mailer->to($request->email)->send(new ContactMail($title,$main));
    return redirect('/management');
    }

    public function itemSearch(Request $request){
    $ItemItems=Item::with('purchases')->ItemSearch($request->name)->get();
    $categories=Category::CategorySearch($request->name)->get();
    $categoriesItemIds=[];
    foreach($categories as $category){
    $categoriesItemIds[]=$category->item_id;
    }
    $categoriesItems=[];
    foreach($categoriesItemIds as $categoriesItemId){
    $categoriesItems[]=Item::with('purchases')->findOrFail($categoriesItemId);
    }
    $collection_categoriesItems = collect($categoriesItems);
    $newItems = collect($ItemItems)->merge($collection_categoriesItems);
    $items = $newItems->unique('id');
    return view('/management',compact('items'));
    }

    public function proceed(Request $request){
    $proceedUsers=User::with('proceeds')->NameSearch($request->name)->EmailSearch($request->email)->get();
    return view('/management',compact('proceedUsers'));
    }
}
