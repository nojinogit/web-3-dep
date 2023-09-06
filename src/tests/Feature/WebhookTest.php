<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Carbon\Carbon;
use App\Mail\DepositedMail;
use Illuminate\Support\Facades\Mail;

class WebhookTest extends TestCase
{
    use RefreshDatabase;

    public function testHandlePayment()
    {
        Mail::fake();

        $user = User::factory()->create();
        $item = Item::factory()->create(['user_id' => $user->id]);
        $purchase = Purchase::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'payment'=> 'test',
            'postcode'=> '111-1111',
            'address'=> 'test',
            'payment_intent_id' => 'test_payment_intent_id'
        ]);

        $response = $this->postJson('/stripe/webhook', [
            'type' => 'payment_intent.succeeded',
            'data' => [
                'object' => [
                    'id' => 'test_payment_intent_id'
                ]
            ]
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('purchases', [
            'id' => $purchase->id,
            'deposited' => Carbon::now()
        ]);
        Mail::assertSent(DepositedMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
        $this->assertDatabaseHas('proceeds', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'proceed' => $item->price
        ]);
    }
}
