<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#121212] text-gray-200 font-sans antialiased flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md px-6">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">LMP <span class="text-[#D4AF37]">Admin</span></h1>
            <p class="text-gray-500 text-sm">Sign in to manage your portfolio</p>
        </div>

        <div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl p-8">
            @if($errors->any())
            <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 bg-[#121212] border border-[#2A2A2A] rounded-xl text-white placeholder-gray-600 focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 transition-all duration-300 outline-none"
                        placeholder="admin@example.com">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 bg-[#121212] border border-[#2A2A2A] rounded-xl text-white placeholder-gray-600 focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 transition-all duration-300 outline-none"
                        placeholder="••••••••">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="remember" name="remember" class="rounded border-[#2A2A2A] bg-[#121212] text-[#D4AF37]">
                    <label for="remember" class="text-sm text-gray-400">Remember me</label>
                </div>
                <button type="submit" class="w-full py-3 bg-[#7A1C1C] rounded-xl font-semibold text-white hover:bg-[#D4AF37] hover:text-[#121212] transition-all duration-300 hover:shadow-[0_0_20px_rgba(212,175,55,0.2)]">
                    Sign In
                </button>
            </form>
        </div>

        <p class="text-center mt-6 text-gray-600 text-xs">
            <a href="{{ route('home') }}" class="hover:text-[#D4AF37] transition-colors duration-300">&larr; Back to Portfolio</a>
        </p>
    </div>
</body>
</html>
