<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp() : void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    /**
     * Login Flow
     * @param  User $user   Optional User to be logged In
     * @return User $user   Successfully logged in user
     */
    protected function signIn(User $user = null)
    {
        $user = $user ?: User::find(1);

        $this->actingAs($user);

        return $user;
    }
}
