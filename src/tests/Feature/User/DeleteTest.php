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
class DeleteTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    // @test
    public function testStatus200WhenDeletingUser()
    {
        $user = User::factory()->create();
        $this->deleteJson(\route('user.destroy', ['user' => $user->id]))->assertOk();
    }

    // @test
    public function testDeletedFromDB()
    {
        $user = User::factory()->create();
        self::assertSame(1, User::count());
        $this->deleteJson(\route('user.destroy', ['user' => $user->id]));
        self::assertSame(0, User::count());
        // make sure it is soft deleted
        $this->assertDatabaseCount('users', 1);
    }
}
