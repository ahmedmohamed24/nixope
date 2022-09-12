<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class ShowTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    // @test
    public function testStatus200WhenListingUsers()
    {
        User::factory()->count(10)->create();
        $this->getJson(\route('user.index'))->assertOk();
    }

    // @test
    public function testListingUsersData()
    {
        User::factory()->count(10)->create();
        $this->getJson(\route('user.index'))->assertJsonCount(10, 'data');
    }

    // @test
    public function testShowAUser()
    {
        $user = User::factory()->create();
        $this->getJson(\route('user.show', ['user' => $user->id]))->assertOk()->assertJsonFragment(['name' => $user->name]);
        // hit id not exists
        $this->getJson(\route('user.show', ['user' => $user->id + 1]))->assertNotFound();
    }
}
