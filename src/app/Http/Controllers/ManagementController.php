<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
}
