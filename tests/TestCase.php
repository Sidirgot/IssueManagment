<?php

namespace Tests;

use App\Issue;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Passport signInAs as a given in role.
     *
     * @param string $role
     * @return \App\User $user
     */
    public function signInAs($role)
    {
        $user = factory(User::class)->create(['role' => $role]);

        Passport::actingAs($user);

        return $user;
    }
}
