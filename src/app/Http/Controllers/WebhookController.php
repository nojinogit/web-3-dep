<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{

public function handlePaymentIntentSucceeded(Request $request){
    Purchase::find(1)->update(['deposited' => $request->data['object']['id']]);
    //Purchase::find(1)->update(['deposited' => $request['type']]);
}
}
