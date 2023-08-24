<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Mail;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;


    public function testPurchase()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['user_id'=>$user->id]);
        $response = $this->actingAs($user)->get('/purchase/' . $item->id);
        $response->assertStatus(200);
    }

    public function testAddress()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['user_id'=>$user->id]);
        $response = $this->actingAs($user)->get('/purchase/address/' . $item->id);
        $response->assertStatus(200);
    }

    public function testAddressChange()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['user_id'=>$user->id]);
        $response = $this->actingAs($user)->post('/purchase/address', [
            'item_id' => $item->id,
            'postcode' => '1234567',
            'address' => 'New Address',
            'building' => 'New Building'
        ]);
        $response->assertStatus(200);
        $response->assertViewHas('user', function ($viewUser) use ($user) {
            return $viewUser->id === $user->id &&
                $viewUser->postcode === '1234567' &&
                $viewUser->address === 'New Address' &&
                $viewUser->building === 'New Building';
        });
    }

    public function testBankTransfer()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['user_id'=>$user->id,'price'=>100]);
        $response = $this->actingAs($user)->post('/bankTransfer', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'cash' => 1000,
            'price'=>100,
            'usePoint' => 0,
            'getPoint' => 0,
            'postcode' => '123-4567',
            'address' => 'New Address',
            'building' => 'New Building',
            'payment' => 'Bank Transfer'
        ]);
        $response->assertRedirect('/myPage/purchase');
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postcode' => '123-4567',
            'address' => 'New Address',
            'building' => 'New Building',
            'payment' => 'Bank Transfer',
            'cash' => 1000,
            'point' => 0
        ]);
    }

    public function testKonbini()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['user_id'=>$user->id,'price'=>100]);
        $response = $this->actingAs($user)->post('/konbini', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'cash' => 1000,
            'price'=>100,
            'usePoint' => 0,
            'getPoint' => 0,
            'postcode' => '123-4567',
            'address' => 'New Address',
            'building' => 'New Building',
            'payment' => 'Konbini'
        ]);
        $response->assertRedirect('/myPage/purchase');
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postcode' => '123-4567',
            'address' => 'New Address',
            'building' => 'New Building',
            'payment' => 'Konbini',
            'cash' => 1000,
            'point' => 0
        ]);
    }

    public function testCredit()
    {
        Mail::fake();
        $user = User::factory()->create();
        $item = Item::factory()->create(['user_id'=>$user->id,'price'=>100]);
        $response = $this->actingAs($user)->post('/credit', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'cash' => 1000,
            'price'=>1000,
            'usePoint' => 0,
            'getPoint' => 0,
            'postcode' => '123-4567',
            'address' => 'New Address',
            'building' => 'New Building',
            'payment' => 'Credit',
            'stripeToken' => 'tok_visa'
        ]);
        $response->assertRedirect('/myPage/purchase');
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postcode' => '123-4567',
            'address' => 'New Address',
            'building' => 'New Building',
            'payment' => 'Credit',
            'cash' => 1000,
            'point' => 0
        ]);
    }

}
