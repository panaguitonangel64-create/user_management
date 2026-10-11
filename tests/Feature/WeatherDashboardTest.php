<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_displays_weather_information(): void
    {
        Http::fake([
            'api.open-meteo.com/*' => Http::response([
                'timezone' => 'Asia/Manila',
                'current' => [
                    'temperature_2m' => 24.6,
                    'relative_humidity_2m' => 92,
                    'wind_speed_10m' => 1.3,
                    'weather_code' => 3,
                ],
            ], 200),
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'role' => 'Administrator',
        ]);

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Weather Overview')
            ->assertSee('Arakan')
            ->assertSee('24.6°C')
            ->assertSee('Overcast')
            ->assertSee('92%')
            ->assertSee('1.3');
    }

    public function test_admin_dashboard_shows_fallback_when_weather_api_fails(): void
    {
        Http::fake([
            'geocoding-api.open-meteo.com/*' => Http::response([], 500),
            'api.open-meteo.com/*' => Http::response([], 500),
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin2@test.com',
            'role' => 'Administrator',
        ]);

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Weather information is currently unavailable');
    }
}
