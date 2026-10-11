<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_and_admin_can_view_the_user_table(): void
    {
        $staff = User::factory()->create([
            'name' => 'Staff User',
            'email' => 'staff@test.com',
            'role' => 'Staff',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'role' => 'Administrator',
        ]);

        $this->actingAs($staff)
            ->get('/users')
            ->assertOk()
            ->assertSee('User Management Module');

        $this->actingAs($admin)
            ->get('/users')
            ->assertOk()
            ->assertSee('User Management Module');
    }

    public function test_customer_cannot_view_the_user_table(): void
    {
        $customer = User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@test.com',
            'role' => 'Customer',
        ]);

        $this->actingAs($customer)
            ->get('/users')
            ->assertForbidden();
    }

    public function test_admin_can_manage_other_users(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'role' => 'Administrator',
        ]);

        $targetUser = User::factory()->create([
            'name' => 'Target User',
            'email' => 'target@test.com',
            'role' => 'Customer',
        ]);

        $this->actingAs($admin)
            ->get('/users')
            ->assertOk();

        $this->actingAs($admin)
            ->get('/users/' . $targetUser->id . '/edit')
            ->assertOk();

        $this->actingAs($admin)
            ->delete('/users/' . $targetUser->id)
            ->assertRedirect('/users');
    }
}
