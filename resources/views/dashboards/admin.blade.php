<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
        }
        .container {
            max-width: 1100px;
            margin: 60px auto;
            padding: 32px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        }
        h1 {
            margin-top: 0;
            font-size: 2.2rem;
        }
        .welcome {
            font-size: 1.1rem;
            margin-bottom: 24px;
        }
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 24px;
        }
        .card {
            background: #f8fafc;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }
        .card h3 {
            margin-top: 0;
            margin-bottom: 12px;
        }
        .weather-card {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 1px solid #bfdbfe;
        }
        .weather-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid rgba(148, 163, 184, 0.35);
        }
        .weather-row:last-child {
            border-bottom: none;
        }
        .weather-error {
            margin: 0;
            color: #b91c1c;
            font-weight: 600;
        }
        .link-btn, .logout-btn {
            display: inline-block;
            margin-top: 12px;
            padding: 10px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }
        .link-btn {
            background: #2563eb;
            color: white;
        }
        .logout-btn {
            background: #1f2937;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome Admin!</h1>
        <p class="welcome">Logged in as: {{ Auth::user()->name }} ({{ Auth::user()->role }})</p>

        <div class="card-grid">
            <div class="card">
                <h3>User Management</h3>
                <p>Manage all registered users and their roles.</p>
                <a href="{{ route('users.index') }}" class="link-btn">Manage Users Module</a>
            </div>

            <div class="card weather-card">
                <h3>Weather Overview</h3>

                @if (!empty($weather['error']))
                    <p class="weather-error">{{ $weather['error'] }}</p>
                @else
                    <div class="weather-row">
                        <span>Location</span>
                        <strong>{{ $weather['location'] }}</strong>
                    </div>
                    <div class="weather-row">
                        <span>Temperature</span>
                        <strong>{{ $weather['temperature'] }}°C</strong>
                    </div>
                    <div class="weather-row">
                        <span>Condition</span>
                        <strong>{{ $weather['condition'] }}</strong>
                    </div>
                    <div class="weather-row">
                        <span>Humidity</span>
                        <strong>{{ $weather['humidity'] }}%</strong>
                    </div>
                    <div class="weather-row">
                        <span>Wind Speed</span>
                        <strong>{{ $weather['wind_speed'] }} km/h</strong>
                    </div>
                @endif
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" style="margin-top: 24px;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>