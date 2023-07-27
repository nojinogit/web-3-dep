<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Mail\BankTransferMail;
use Illuminate\Contracts\Mail\Mailer;

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

    public function confirm(Request $request,Mailer $mailer){
    $purchase=$request->only(['user_id','item_id','postcode','address','building','payment']);
    Purchase::create($purchase);

    $item=Item::findOrFail($request->item_id);
    $user=User::findOrFail(Auth::user()->id);

    Stripe::setApiKey(config('stripe.stripe_secret_key'));
    $customer = \Stripe\Customer::create([
    'name' => $user->name,
    'email' => $user->email,
    ]);

    $intent = PaymentIntent::create([
    'amount' => $item->price,
    'currency' => 'jpy',
    'customer' => $customer->id,
    'payment_method_types' => ['customer_balance'],
    'payment_method_data' => [
    'type' => 'customer_balance',
    ],
    'payment_method_options' => [
    'customer_balance' => [
        'funding_type' => 'bank_transfer',
        'bank_transfer' => [
        'type' => 'jp_bank_transfer',
        ],
    ],
    ],
    'confirm' => true,
    ]);

    $nextAction=$intent->next_action;
    $item=Item::findOrFail($request->item_id);
    $user=User::findOrFail($request->user_id);

    $mailer->to($user->email)->send(new BankTransferMail($nextAction,$item,$user));

    return redirect('/myPage');
    }
}
