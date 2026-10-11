<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_is_available(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200)
            ->assertSee('Register')
            ->assertSee('name')
            ->assertSee('email');
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'Customer',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'role' => 'Customer',
        ]);
        $this->assertTrue(User::where('email', 'newuser@example.com')->exists());
    }
}
