<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_has_styled_form(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200)
            ->assertSee('Login Page')
            ->assertSee('login-wrapper')
            ->assertSee('login-card');
    }
}
