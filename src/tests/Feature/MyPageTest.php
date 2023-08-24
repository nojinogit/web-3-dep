<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class MyPageTest extends TestCase
{
    use RefreshDatabase;

    public function testMyPage()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/myPage');
        $response->assertStatus(200);
    }

    public function testMyPagePurchase()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/myPage/purchase');
        $response->assertStatus(200);
    }

    public function testProfile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/myPage/profile');
        $response->assertStatus(200);
    }

    public function testProfileUpdate()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->put('/myPage/profile', [
            'name' => 'New Name',
            'postcode' => '1234567',
            'address' => 'New Address',
            'building' => 'New Building'
        ]);
        $response->assertRedirect('/myPage/profile');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'postcode' => '1234567',
            'address' => 'New Address',
            'building' => 'New Building'
        ]);
    }

    public function testBankNumber()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/myPage/bankNumber');
        $response->assertStatus(200);
    }

    public function testBankNumberUpdate()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->put('/myPage/bankNumber', [
            'bank' => 'New Bank',
            'bank_branch' => 'New Branch',
            'bank_type' => 'New Type',
            'bank_number' => '12345678'
        ]);
        $response->assertRedirect('/myPage/bankNumber');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'bank' => 'New Bank',
            'bank_branch' => 'New Branch',
            'bank_type' => 'New Type',
            'bank_number' => '12345678'
        ]);
    }
}
