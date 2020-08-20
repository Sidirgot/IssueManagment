<?php

namespace Tests\Feature\API\Team;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function a_user_can_update_his_profile_information()
    {
        $user = $this->signInAs('user');

        $data = ['name' => 'tasos'];

        $this->json('patch', route('profile.update', $user->id), $data)->assertStatus(200)->decodeResponseJson();

        $this->assertDatabaseMissing('users', ['name' => $user->name]);
        $this->assertDatabaseHas('users', ['name' => $data['name']]);
    }
}