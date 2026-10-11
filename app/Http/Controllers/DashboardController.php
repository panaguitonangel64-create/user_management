<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function admin()
    {
        $weather = $this->getWeatherData();

        return view('dashboards.admin', compact('weather'));
    }

    public function staff()
    {
        return view('dashboards.staff');
    }

    public function customer()
    {
        return view('dashboards.customer');
    }

    protected function getWeatherData(): array
    {
        $city = config('services.weather.default_city', env('WEATHER_DEFAULT_CITY', 'Arakan, North Cotabato'));
        $geoBaseUrl = config('services.weather.geocoding_url', env('WEATHER_GEOCODING_URL', 'https://geocoding-api.open-meteo.com/v1'));
        $forecastBaseUrl = config('services.weather.base_url', env('WEATHER_API_BASE_URL', 'https://api.open-meteo.com/v1'));
        $latitude = config('services.weather.latitude', env('WEATHER_LATITUDE'));
        $longitude = config('services.weather.longitude', env('WEATHER_LONGITUDE'));
        $locationName = $city;
        $country = '';

        try {
            if (empty($latitude) || empty($longitude)) {
                $location = null;
                $searchQueries = [
                    $city,
                    str_replace(', North Cotabato', '', $city),
                    trim(str_replace(', North Cotabato', '', $city) . ' Philippines'),
                    'Arakan Philippines',
                ];

                foreach ($searchQueries as $query) {
                    $geocodeResponse = Http::timeout(10)->get($geoBaseUrl . '/search', [
                        'name' => $query,
                        'count' => 1,
                        'language' => 'en',
                        'format' => 'json',
                    ]);

                    if (! $geocodeResponse->failed()) {
                        $location = $geocodeResponse->json('results.0');

                        if (! empty($location)) {
                            break;
                        }
                    }
                }

                if (empty($location)) {
                    return $this->weatherUnavailable($city);
                }

                $latitude = $location['latitude'] ?? null;
                $longitude = $location['longitude'] ?? null;
                $locationName = $location['name'] ?? $city;
                $country = $location['country'] ?? '';
            }

            if (empty($latitude) || empty($longitude)) {
                return $this->weatherUnavailable($locationName);
            }

            $forecastResponse = Http::timeout(10)->get($forecastBaseUrl . '/forecast', [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'current' => 'temperature_2m,relative_humidity_2m,wind_speed_10m,weather_code',
                'timezone' => 'auto',
            ]);

            if ($forecastResponse->failed()) {
                return $this->weatherUnavailable($locationName . ($country ? ', ' . $country : ''));
            }

            $current = $forecastResponse->json('current');

            if (! is_array($current) || empty($current)) {
                return $this->weatherUnavailable($locationName . ($country ? ', ' . $country : ''));
            }

            $temperature = $current['temperature_2m'] ?? null;
            $humidity = $current['relative_humidity_2m'] ?? null;
            $windSpeed = $current['wind_speed_10m'] ?? null;
            $weatherCode = $current['weather_code'] ?? 0;

            if ($temperature === null || $humidity === null || $windSpeed === null) {
                return $this->weatherUnavailable($locationName . ($country ? ', ' . $country : ''));
            }

            return [
                'location' => $locationName . ($country ? ', ' . $country : ''),
                'temperature' => round((float) $temperature, 1),
                'condition' => $this->weatherDescription((int) $weatherCode),
                'humidity' => (int) $humidity,
                'wind_speed' => round((float) $windSpeed, 1),
                'error' => null,
            ];
        } catch (\Throwable $exception) {
            return $this->weatherUnavailable($locationName . ($country ? ', ' . $country : ''));
        }
    }

    protected function weatherUnavailable(string $location): array
    {
        return [
            'location' => $location,
            'temperature' => null,
            'condition' => 'Weather information is currently unavailable',
            'humidity' => null,
            'wind_speed' => null,
            'error' => 'Weather information is currently unavailable.',
        ];
    }

    protected function weatherDescription(int $weatherCode): string
    {
        $conditions = [
            0 => 'Clear sky',
            1 => 'Mainly clear',
            2 => 'Partly cloudy',
            3 => 'Overcast',
            45 => 'Fog',
            48 => 'Depositing rime fog',
            51 => 'Light drizzle',
            53 => 'Moderate drizzle',
            55 => 'Dense drizzle',
            56 => 'Light freezing drizzle',
            57 => 'Dense freezing drizzle',
            61 => 'Slight rain',
            63 => 'Moderate rain',
            65 => 'Heavy rain',
            66 => 'Light freezing rain',
            67 => 'Heavy freezing rain',
            71 => 'Slight snow fall',
            73 => 'Moderate snow fall',
            75 => 'Heavy snow fall',
            77 => 'Snow grains',
            80 => 'Rain showers',
            81 => 'Heavy rain showers',
            82 => 'Violent rain showers',
            85 => 'Snow showers',
            86 => 'Heavy snow showers',
            95 => 'Thunderstorm',
            96 => 'Thunderstorm with hail',
            99 => 'Severe thunderstorm',
        ];

        return $conditions[$weatherCode] ?? 'Weather conditions unavailable';
    }
}