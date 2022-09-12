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
class UpdateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    // @test
    public function testStatus200WhenUpdatingUser()
    {
        $user = User::factory()->create();
        $this->putJson(\route('user.update', ['user' => $user->id]), User::factory()->raw())->assertOk();
    }

    // @test
    public function testUserDataUpdatedInDB()
    {
        $user = User::factory()->create();
        $newUser = User::factory()->raw();
        $this->putJson(\route('user.update', ['user' => $user->id]), $newUser)->assertOk();
        self::assertEquals($newUser['name'], $user->refresh()->name);
        self::assertEquals($newUser['email'], $user->refresh()->email);
    }

    // @test
    public function testUserUpdatingUniqueEmail()
    {
        $user = User::factory()->create();
        // create a new user with the same old email to check unique validation rule
        $newUser = User::factory()->raw(['email' => $user->email]);
        $this->putJson(\route('user.update', ['user' => $user->id]), $newUser)->assertOk();
    }
}
