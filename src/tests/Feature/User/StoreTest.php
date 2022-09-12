<?php

namespace Tests\Feature\User;

use App\Events\UserCreatedEvent;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class StoreTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    // @test
    public function testStatus201WhenStoringUser()
    {
        $this->postJson(\route('user.store'), User::factory()->raw())->assertCreated();
    }

    // @test
    public function testUserIsStoredInDB()
    {
        $this->postJson(\route('user.store'), User::factory()->raw())->assertCreated();
        $this->assertDatabaseCount('users', 1);
    }

    // @test
    public function testUserCreatedEventIsDispatched()
    {
        Event::fake();
        $this->postJson(\route('user.store'), User::factory()->raw())->assertCreated();
        Event::assertDispatched(UserCreatedEvent::class);
    }

    // @test
    public function testValidationOnNullableName()
    {
        $this->postJson(\route('user.store'), User::factory()->raw(['name' => null]))
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name')
        ;
    }

    // @test
    public function testValidationOnNameLength()
    {
        $this->postJson(\route('user.store'), User::factory()->raw(['name' => $this->faker()->sentence(255)]))
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name')
        ;
    }

    // @test
    public function testValidationOnEmail()
    {
        $this->postJson(\route('user.store'), User::factory()->raw(['email' => null]))
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('email')
        ;
    }

    // @test
    public function testValidationOnEmailUnique()
    {
        $email = $this->faker()->safeEmail();
        $this->postJson(\route('user.store'), User::factory()->raw(['email' => $email]))->assertCreated();
        $this->postJson(\route('user.store'), User::factory()->raw(['email' => $email]))->assertUnprocessable()
            ->assertJsonValidationErrorFor('email')
        ;
    }

    // @test
    public function testValidationOnRoles()
    {
        $this->postJson(\route('user.store'), User::factory()->raw(['roles' => [Role::latest('id')->first()->id + 1]]))
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('roles.0')
        ;
    }
}
