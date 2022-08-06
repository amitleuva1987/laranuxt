<?php

namespace Tests\Php\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_retrive_a_user()
    {
        $user = User::factory()->create();
        $response = $this->get('/users/' . $user->id);

        $response->assertStatus(200);
    }

    public function test_can_not_retrive_a__non_existed_user()
    {
        $user = User::factory()->create();
        $response = $this->get('/users/2');

        $response->assertStatus(404);
    }
}
