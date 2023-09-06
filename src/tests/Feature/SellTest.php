<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\UploadedFile;


class SellTest extends TestCase
{
    use RefreshDatabase;

    public function test_sell()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/sell');

        $response->assertStatus(200);
    }

    public function testExhibit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/exhibit', [
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'condition' => '新品、未使用',
            'explanation' => 'テスト説明',
            'price' => 1000,
            'category' => ['カテゴリ1', 'カテゴリ2'],
            'image' => UploadedFile::fake()->image('test.jpg')
        ]);

        $response->assertRedirect('/myPage');
        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'condition' => '新品、未使用',
            'explanation' => 'テスト説明',
            'price' => 1000,
        ]);
        $item = Item::first();
        $this->assertDatabaseHas('categories', [
            'item_id' => $item->id,
            'category' => 'カテゴリ1'
        ]);
        $this->assertDatabaseHas('categories', [
            'item_id' => $item->id,
            'category' => 'カテゴリ2'
        ]);
    }

    public function testWithdraw()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $item = Item::factory()->create(['user_id' => $user->id]);

        $response = $this->delete('/withdraw/'.$item->id);

        $response->assertRedirect('/myPage');
        $this->assertSoftDeleted($item);
    }

}
