<?php

namespace Tests\Feature\API\Managers;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function managers_can_see_all_the_testers_and_all_the_developers_in_the_system()
    {
        $this->signInAs('manager');

        factory(User::class, 4)->create(['role' => 'tester']);
        factory(User::class, 4)->create(['role' => 'developer']);

        $response = $this->json('get',route('users.index'))->assertStatus(200)->decodeResponseJson();

        $this->assertEquals(User::onlyTestersAndDevelopers()->count(), count($response['data']));
    }

    /** @test */
    public function managers_can_add_new_users()
    {
        $this->signInAs('manager');

        $user = [
            'name' => 'username',
            'email' => 'user@email.com',
            'password' => '12451245',
            'password_confirmation' => '12451245',
            'role' => 'tester'
        ];

        $response = $this->json('post', route('users.store'), $user)->assertStatus(201)->decodeResponseJson();

        $this->assertEquals($response['name'], $user['name']);
        $this->assertEquals($response['email'], $user['email']);
        $this->assertDatabaseHas('users', ['name' => $user['name']]);
        $this->assertDatabaseHas('users', ['email' => $user['email']]);
        $this->assertDatabaseHas('users', ['role' => $user['role']]);
    }

    /** @test */
    public function managers_can_fetch_a_user_by_its_id()
    {
        $this->signInAs('manager');

        $user = factory(User::class)->create(['role' => 'tester']);

        $response = $this->json('get', route('users.show', $user->id))->assertStatus(200)->decodeResponseJson();

        $this->assertEquals($response['name'], $user['name']);
        $this->assertEquals($response['email'], $user['email']);
    }

    /** @test */
    public function managers_can_update_a_users_information_and_role()
    {
        $this->signInAs('manager');

        $user = factory(User::class)->create(['role' => 'tester']);

        $newData = ['name' => 'new name', 'email' => 'new@email.com', 'role' => 'developer'];

        $response = $this->json('patch', route('users.update',$user->id), $newData)->assertStatus(200)->decodeResponseJson();

        $this->assertEquals($response['name'], $newData['name']);
        $this->assertEquals($response['email'], $newData['email']);

        $this->assertDatabaseMissing('users', ['name' => $user->name]);
        $this->assertDatabaseMissing('users', ['email' => $user->email]);
        $this->assertDatabaseHas('users', ['name' => $newData['name']]);
        $this->assertDatabaseHas('users', ['email' => $newData['email']]);
    }

    /** @test */
    public function managers_can_delete_a_user_from_the_system()
    {
        $this->signInAs('manager');

        $user = factory(User::class)->create(['role' => 'tester']);

        $this->json('delete', route('users.destroy', $user->id))->assertStatus(200);

        $this->assertDatabaseMissing('users', ['name' => $user->name]);
        $this->assertDatabaseMissing('users', ['name' => $user->email]);
    }
}
