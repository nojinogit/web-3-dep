<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class WebTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response = $this->get('/no_route');

        $response->assertStatus(404);

        User::factory()->create([
            'name'=>'aaa',
            'email'=>'bbb@ccc.com',
            'password'=>bcrypt('test12345'),
            'role'=>1,
            'point'=>1,

        ]);

        $user = User::where([
            'name'=>'aaa',
            'email'=>'bbb@ccc.com',
            'role'=>1,
            'point'=>1,
        ])->first();

        $this->assertTrue(Hash::check('test12345', $user->password));

    }
}
