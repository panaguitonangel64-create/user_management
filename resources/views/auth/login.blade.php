<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PawCare Pet Care Services</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4">

    <!-- Background Decorative Glows -->
    <div class="fixed top-20 left-20 w-72 h-72 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed bottom-20 right-20 w-72 h-72 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="login-wrapper w-full max-w-md bg-slate-800/80 backdrop-blur-md border border-slate-700/60 rounded-2xl shadow-2xl overflow-hidden">
        <div class="login-card w-full max-w-md">
        <h2 class="sr-only">Login Page</h2>
        
        <!-- ATTRACTIVE BRAND HEADER -->
        <div class="p-8 pb-6 text-center border-b border-slate-700/50 bg-gradient-to-b from-slate-800/90 to-transparent">
            <!-- Logo Icon -->
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 text-white shadow-lg shadow-blue-500/30 mb-4 transform hover:scale-105 transition-transform duration-300">
                <i class="fa-solid fa-paw text-3xl"></i>
            </div>

            <!-- Main Heading & Tagline -->
            <h1 class="text-3xl font-extrabold text-white tracking-tight">
                Paw<span class="text-blue-500">Care</span>
            </h1>
            <p class="text-xs uppercase tracking-widest text-blue-400 font-semibold mt-1">
                Pet Care Services & Management
            </p>
            <p class="text-sm text-slate-400 mt-2">
                Welcome back! Log in to manage bookings, health records, and care schedules.
            </p>
        </div>

        <!-- LOGIN FORM SECTION -->
        <div class="p-8 pt-6">
            
            <!-- Session Status Alert -->
            @if (session('status'))
                <div class="mb-4 text-sm text-green-400 bg-green-950/50 border border-green-800 p-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-1">
                        Email Address
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="customer@gmail.com"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white placeholder-slate-500 text-sm transition duration-200" />
                    </div>
                    @error('email')
                        <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-medium text-slate-300">
                            Password
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-xs text-blue-400 hover:text-blue-300 transition-colors" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input id="password" type="password" name="password" required
                            placeholder="••••••••"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white placeholder-slate-500 text-sm transition duration-200" />
                    </div>
                    @error('password')
                        <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" 
                        class="w-4 h-4 rounded bg-slate-900 border-slate-700 text-blue-600 focus:ring-blue-500 focus:ring-offset-slate-800">
                    <label for="remember_me" class="ml-2 text-sm text-slate-400">
                        Remember me
                    </label>
                </div>

                <!-- Login Button -->
                <button type="submit" 
                    class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 transform active:scale-[0.98] transition duration-200 text-sm">
                    Log In
                </button>
            </form>

            <!-- Footer / Register Link -->
            <div class="mt-6 text-center pt-4 border-t border-slate-700/50">
                <p class="text-sm text-slate-400">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-semibold text-blue-400 hover:text-blue-300 transition-colors">
                        Create an account
                    </a>
                </p>
            </div>

        </div>
        </div>
    </div>

</body>
</html>