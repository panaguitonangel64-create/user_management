<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .login-card {
            width: 100%;
            max-width: 480px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #dfe3ea;
            border-radius: 18px;
            padding: 32px 28px;
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.08);
        }

        h2 {
            margin: 0 0 24px;
            font-size: 2rem;
            text-align: left;
            color: #111827;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
        }

        input, select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #fff;
            font-size: 16px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .btn-login {
            width: 100%;
            background: #1f2937;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s ease;
        }

        .btn-login:hover {
            opacity: 0.95;
        }

        .error-box {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #9f1239;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .login-link {
            display: block;
            margin-top: 16px;
            text-align: center;
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <h2>Register</h2>

            @if ($errors->any())
                <div class="error-box">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="Administrator">Administrator</option>
                        <option value="Staff">Staff</option>
                        <option value="Customer" selected>Customer</option>
                    </select>
                </div>

                <button type="submit" class="btn-login">Register</button>
                <a href="{{ route('login') }}" class="login-link">Already have an account? Login</a>
            </form>
        </div>
    </div>
</body>
</html>
