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
use App\Mail\KonbiniMail;
use App\Mail\CreditMail;
use App\Mail\SendMail;
use \Carbon\Carbon;
use Illuminate\Contracts\Mail\Mailer;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\SendRequest;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function purchase($id){
    $item=Item::findOrFail($id);
    $user=User::findOrFail(Auth::user()->id);
    if($user->stripe_id!==null){
    Stripe::setApiKey(config('stripe.stripe_secret_key'));
    $customer = \Stripe\Customer::retrieve(['id' => $user->stripe_id,'expand' => ['sources'],]);
    $card_id = $customer->default_source;
    $card_info = $customer->sources->retrieve($card_id);
    return view('/purchase',compact('item','user','card_info'));
    }
    return view('/purchase',compact('item','user'));
    }

    public function address($id){
    $item=Item::findOrFail($id);
    $user=User::findOrFail(Auth::user()->id);
    return view('/address',compact('item','user'));
    }

    public function addressChange(SendRequest $request){
    $item=Item::findOrFail($request->item_id);
    $user=User::findOrFail(Auth::user()->id);
    $user['postcode']=$request->postcode;
    $user['address']=$request->address;
    $user['building']=$request->building;
    if($user->stripe_id!==null){
    Stripe::setApiKey(config('stripe.stripe_secret_key'));
    $customer = \Stripe\Customer::retrieve(['id' => $user->stripe_id,'expand' => ['sources'],]);
    $card_id = $customer->default_source;
    $card_info = $customer->sources->retrieve($card_id);
    return view('/purchase',compact('item','user','card_info'));
    }
    return view('/purchase',compact('item','user'));
    }

    public function bankTransfer(PurchaseRequest $request,Mailer $mailer){

    $item=Item::findOrFail($request->item_id);
    $user=User::findOrFail(Auth::user()->id);

    Stripe::setApiKey(config('stripe.stripe_secret_key'));
    $customer = \Stripe\Customer::create([
    'name' => $user->name,
    'email' => $user->email,
    ]);

    $intent = PaymentIntent::create([
    'amount' => $request->cash,
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

    $purchase=$request->only(['user_id','item_id','postcode','address','building','payment','cash']);
    $purchase['point'] = $request->usePoint;
    $purchase_id=Purchase::create($purchase);

    Purchase::findOrFail($purchase_id->id)->update(['payment_intent_id' => $intent->id]);

    DB::transaction(function () use ($user, $request) {
    $point = intval($user->point);
    $usePoint = intval($request->usePoint);
    $getPoint = intval($request->getPoint);

    $newPoint = $point - $usePoint + $getPoint;

    $user->point = $newPoint;
    $user->save();
    });

    $nextAction=$intent->next_action;
    $cash=$request->cash;
    $mailer->to($user->email)->send(new BankTransferMail($nextAction,$user,$cash));

    return redirect('/myPage/purchase');
    }

    public function konbini(PurchaseRequest $request,Mailer $mailer){

    $item=Item::findOrFail($request->item_id);
    $user=User::findOrFail(Auth::user()->id);

    Stripe::setApiKey(config('stripe.stripe_secret_key'));
    $customer = \Stripe\Customer::create([
    'name' => $user->name,
    'email' => $user->email,
    ]);

    $intent = PaymentIntent::create([
    'amount' => $request->cash,
    'currency' => 'jpy',
    'customer' => $customer->id,
    'payment_method_types' => ['konbini'],
    'payment_method_data' => ['type' => 'konbini','billing_details'=> [
            'name' => $user->name,
            'email' => $user->email,]],
    'payment_method_options' => ['konbini' => ['expires_after_days' => 5,],],
    'confirm' => true,
    ]);

    $purchase=$request->only(['user_id','item_id','postcode','address','building','payment','cash']);
    $purchase['point'] = $request->usePoint;
    $purchase_id=Purchase::create($purchase);

    Purchase::findOrFail($purchase_id->id)->update(['payment_intent_id' => $intent->id]);

    DB::transaction(function () use ($user, $request) {
    $point = intval($user->point);
    $usePoint = intval($request->usePoint);
    $getPoint = intval($request->getPoint);

    $newPoint = $point - $usePoint + $getPoint;

    $user->point = $newPoint;
    $user->save();
    });

    $nextAction=$intent->next_action;
    $cash=$request->cash;
    $mailer->to($user->email)->send(new KonbiniMail($nextAction,$user,$cash));

    return redirect('/myPage/purchase');
    }

    public function credit(PurchaseRequest $request,Mailer $mailer){

    $item=Item::findOrFail($request->item_id);
    $user=User::findOrFail(Auth::user()->id);

    Stripe::setApiKey(config('stripe.stripe_secret_key'));

    $token = $request->input('stripeToken');

    $customer = \Stripe\Customer::create([
        'name' => $user->name,
        'email' => $user->email,
        'source' => $token,
    ]);


    $user->stripe_id = $customer->id;
    $user->save();

    try {
        $charge = \Stripe\Charge::create([
            'amount' => $request->cash,
            'currency' => 'jpy',
            'customer' => $customer->id,
            'description' => 'credit決済'
        ]);

        $purchase=$request->only(['user_id','item_id','postcode','address','building','payment','cash']);
        $purchase['point'] = $request->usePoint;
        $purchase['payment_intent_id'] = $charge->id;
        $purchase['deposited'] = Carbon::now();
        $purchase_id=Purchase::create($purchase);

        DB::transaction(function () use ($user, $request) {
        $point = intval($user->point);
        $usePoint = intval($request->usePoint);
        $getPoint = intval($request->getPoint);

        $newPoint = $point - $usePoint + $getPoint;

        $user->point = $newPoint;
        $user->save();
        });

        $purchase_data=Purchase::with('item.user')->findOrFail($purchase_id->id);
        $mailer->to($purchase_data->item->user->email)->send(new CreditMail($purchase_data));

        return redirect()->route('myPagePurchase');
    } catch (\Exception $e) {

        return back()->with('error', $e->getMessage());
    }
    }

    public function creditReuse(PurchaseRequest $request,Mailer $mailer){

    $item=Item::findOrFail($request->item_id);
    $user=User::findOrFail(Auth::user()->id);

    Stripe::setApiKey(config('stripe.stripe_secret_key'));

    try {
        $charge = \Stripe\Charge::create([
            'amount' => $item->price,
            'currency' => 'jpy',
            'customer' => $user->stripe_id,
            'description' => 'creditReuse決済'
        ]);

        $purchase=$request->only(['user_id','item_id','postcode','address','building','payment','cash']);
        $purchase['point'] = $request->usePoint;
        $purchase['payment_intent_id'] = $charge->id;
        $purchase['deposited'] = Carbon::now();
        $purchase_id=Purchase::create($purchase);

        DB::transaction(function () use ($user, $request) {
        $point = intval($user->point);
        $usePoint = intval($request->usePoint);
        $getPoint = intval($request->getPoint);

        $newPoint = $point - $usePoint + $getPoint;

        $user->point = $newPoint;
        $user->save();
        });

        $purchase_data=Purchase::with('item.user')->findOrFail($purchase_id->id);
        $mailer->to($purchase_data->item->user->email)->send(new CreditMail($purchase_data));

        return redirect()->route('myPagePurchase');
    } catch (\Exception $e) {

        return back()->with('error', $e->getMessage());
    }
    }

    public function send(Request $request,Mailer $mailer){

    Purchase::where('item_id',$request->item_id)->update(['send'=>Carbon::now()]);
    $purchase=Purchase::where('item_id',$request->item_id)->firstOrFail();
    $purchase_data=Purchase::with('item.user','user')->findOrFail($purchase->id);
    $mailer->to($purchase_data->user->email)->send(new SendMail($purchase_data));

    return redirect('/myPage');
    }

}
