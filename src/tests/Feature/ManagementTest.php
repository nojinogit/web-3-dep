<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Proceed;
use App\Mail\ContactMail;
use App\Mail\NoticeOfPaymentMail;
use Carbon\Carbon;

class ManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 100
        ]);
    }

    public function testManagement()
    {
        $response = $this->actingAs($this->user)->get(route('management'));

        $response->assertStatus(200);
    }

    public function testAccount()
    {
        $response = $this->actingAs($this->user)->get(route('account'));

        $response->assertStatus(200);
    }

    public function testAccountDelete()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('accountDelete'), [
            'id' => $user->id
        ]);

        $response->assertRedirect(route('management'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testAccountRole()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->user)->put(route('accountRole'), [
            'id' => $user->id
        ]);

        $response->assertRedirect(route('management'));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'role' => 100]);
    }

    public function testAccountRoleDelete()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->user)->put(route('accountRoleDelete'), [
            'id' => $user->id
        ]);

        $response->assertRedirect(route('management'));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'role' => 1]);
    }

    public function testContactMail()
    {
        \Mail::fake();

        $response = $this->actingAs($this->user)->post(route('contactMail'), [
            'email' => 'test@example.com',
            'title' => 'Test Title',
            'main' => 'Test Main'
        ]);

        \Mail::assertSent(ContactMail::class, function ($mail) {
            return $mail->hasTo('test@example.com') &&
                $mail->title === 'Test Title' &&
                $mail->main === 'Test Main';
        });

        $response->assertRedirect(route('management'));
    }

    public function testItemSearch()
    {
        $user = User::factory()->create();

        $item=Item::factory()->create([
            'name' => 'Test Item',
            'user_id'=>$user->id,
        ]);

        Category::factory()->create([
            'category' => 'Test Category',
            'item_id'=>$item->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('itemSearch'), [
            'category' => 'Test'
        ]);

        $response->assertStatus(200);
    }

    public function testProceed()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);

        $item=Item::factory()->create([
            'name' => 'Test Item',
            'user_id'=>$user->id,
        ]);

        Proceed::factory()->create([
            'user_id'=>$user->id,
            'item_id'=>$item->id,
            'proceed'=>100,
        ]);

        $response = $this->actingAs($this->user)->get(route('proceed'), [
            'name' => 'Test'
        ]);

        $response->assertStatus(200);

        $response = $this->actingAs($this->user)->get(route('proceed'), [
            'email' => 'test@example.com'
        ]);

        $response->assertStatus(200);
    }

    public function testProceedOnly()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);

        $item=Item::factory()->create([
            'name' => 'Test Item',
            'user_id'=>$user->id,
        ]);

        Proceed::factory()->create([
            'user_id'=>$user->id,
            'item_id'=>$item->id,
            'proceed'=>100,
        ]);

        $response = $this->actingAs($this->user)->get(route('proceedOnly'), [
            'name' => 'Test'
        ]);

        $response->assertStatus(200);

        $response = $this->actingAs($this->user)->get(route('proceedOnly'), [
            'email' => 'test@example.com'
        ]);

        $response->assertStatus(200);
    }

    public function testProceedComplete()
    {
        \Mail::fake();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);

        $item=Item::factory()->create([
            'name' => 'Test Item',
            'user_id'=>$user->id,
        ]);

        $proceed=Proceed::factory()->create([
            'user_id'=>$user->id,
            'item_id'=>$item->id,
            'proceed'=>100,
        ]);

        $response = $this->actingAs($this->user)->put(route('proceedComplete'), [
            'user_id' => $proceed->user_id,
            'total' => 1000,
        ]);

        \Mail::assertSent(NoticeOfPaymentMail::class, function ($mail) use ($proceed) {
            return $mail->hasTo('test@example.com') &&
                $mail->total === 1000 &&
                $mail->user->is($proceed->user);
        });

        $response->assertRedirect(route('management'));
        $this->assertDatabaseHas('proceeds', ['id' => $proceed->id, 'complete' => Carbon::now()]);
    }

}
