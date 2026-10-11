<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
        }
        .container {
            max-width: 800px;
            margin: 60px auto;
            padding: 32px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        }
        h1 { margin-top: 0; font-size: 2.2rem; }
        .logout-btn {
            margin-top: 20px;
            padding: 10px 16px;
            background: #1f2937;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome User!</h1>
        <p>Logged in as: {{ Auth::user()->name }} ({{ Auth::user()->role }})</p>

        <form action="{{ route('logout') }}" method="POST" style="margin-top: 24px;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>