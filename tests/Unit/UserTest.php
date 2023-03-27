<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_signIn()
    {
        $this->signIn();
        $this->assertTrue(auth()->check());
    }

    /** @test */
    public function it_can_be_admin()
    {
        $user = User::factory()->create();
        $this->assertFalse($user->hasRole('admin'));

        $user->assignRole('admin');
        $this->assertTrue($user->hasRole('admin'));
    }
}
