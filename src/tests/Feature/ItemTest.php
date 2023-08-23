<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class ItemTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;


    public function test_example(): void
    {
        $response = $this->get(route('index'));

        $response->assertStatus(200);
    }

    public function testSearch()
    {
        $response = $this->get(route('search'));

        $response->assertStatus(200);
    }

    public function testSearchAll()
    {
        $response = $this->get(route('searchAll'));

        $response->assertStatus(200);
    }

    public function testDetail()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('detail', ['id' => $item->id]));

        $response->assertStatus(200);
    }

    public function testRecommendation()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('recommendation'));

        $response->assertStatus(200);
    }

    public function testMyList()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('myList', ['id' => $user->id]));

        $response->assertStatus(200);
    }
}
