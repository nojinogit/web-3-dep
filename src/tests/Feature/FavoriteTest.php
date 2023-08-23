<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Favorite;


class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function testFavoriteStore()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->post(route('favoriteStore'), [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['item_id' => $item->id]);
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function testFavoriteDelete()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $favorite = Favorite::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $item_id = $favorite->item_id;

        $response = $this->delete(route('favoriteDelete'), [
            'user_id' => $user->id,
            'item_id' => $item_id,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['item_id' => $item_id]);
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item_id,
        ]);
    }

    
}
