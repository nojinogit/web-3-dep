<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comment;
use App\Models\User;
use App\Models\Item;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function test_example(): void
    {

        $user = User::factory()->create();

        $item = Item::factory()->create(['user_id' => $user->id]);

        $comment = Comment::factory()->create(['user_id' => $user->id, 'item_id' => $item->id]);

        $response = $this->actingAs($user)->get(route('comment', ['id' => $comment->id]));

        $response->assertStatus(200);

    }

    public function testCommentAdd()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create(['user_id' => $user->id]);

        $data = [
            'comment' => 'テストコメント',
            'user_id' => $user->id,
            'item_id' => $item->id,
        ];

        $response = $this->actingAs($user)->post(route('commentAdd'), $data);

        $response->assertStatus(302);

    }

    public function testCommentDelete()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create(['user_id' => $user->id]);

        $comment = Comment::factory()->create(['user_id' => $user->id, 'item_id' => $item->id]);

        $response = $this->actingAs($user)->delete(route('commentDelete'), ['id' => $comment->id, 'item_id' => $item->id]);

        $response->assertStatus(302);

        $response->assertRedirect(route('comment', ['id' => $item->id]));

        $this->assertSoftDeleted('comments', ['id' => $comment->id]);

    }

}
