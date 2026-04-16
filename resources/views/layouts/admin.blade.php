<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — {{ $title ?? 'Dashboard' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#121212] text-gray-200 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#7A1C1C] flex flex-col fixed h-full z-40">
            <div class="p-6 border-b border-white/10">
                <h1 class="text-lg font-bold text-white">LMP <span class="text-[#D4AF37]">Admin</span></h1>
                <p class="text-xs text-white/50 mt-1">Portfolio Dashboard</p>
            </div>
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-[#D4AF37]' : 'text-white/70 hover:text-white hover:bg-white/10' }} transition-all duration-300">
                    <span class="text-xs font-mono">~</span> Dashboard
                </a>
                <a href="{{ route('projects.index') }}" class="admin-nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('projects.*') ? 'bg-white/15 text-[#D4AF37]' : 'text-white/70 hover:text-white hover:bg-white/10' }} transition-all duration-300">
                    <span class="text-xs font-mono">&gt;</span> Projects
                </a>
                <a href="{{ route('skills.index') }}" class="admin-nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('skills.*') ? 'bg-white/15 text-[#D4AF37]' : 'text-white/70 hover:text-white hover:bg-white/10' }} transition-all duration-300">
                    <span class="text-xs font-mono">*</span> Skills
                </a>
                <a href="{{ route('experiences.index') }}" class="admin-nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('experiences.*') ? 'bg-white/15 text-[#D4AF37]' : 'text-white/70 hover:text-white hover:bg-white/10' }} transition-all duration-300">
                    <span class="text-xs font-mono">#</span> Experience
                </a>
                <a href="{{ route('achievements.index') }}" class="admin-nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('achievements.*') ? 'bg-white/15 text-[#D4AF37]' : 'text-white/70 hover:text-white hover:bg-white/10' }} transition-all duration-300">
                    <span class="text-xs font-mono">+</span> Achievements
                </a>
                <a href="{{ route('certificates.index') }}" class="admin-nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('certificates.*') ? 'bg-white/15 text-[#D4AF37]' : 'text-white/70 hover:text-white hover:bg-white/10' }} transition-all duration-300">
                    <span class="text-xs font-mono">%</span> Certificates
                </a>
                <a href="{{ route('activities.index') }}" class="admin-nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('activities.*') ? 'bg-white/15 text-[#D4AF37]' : 'text-white/70 hover:text-white hover:bg-white/10' }} transition-all duration-300">
                    <span class="text-xs font-mono">^</span> Activities
                </a>
                <a href="{{ route('admin.messages') }}" class="admin-nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.messages*') ? 'bg-white/15 text-[#D4AF37]' : 'text-white/70 hover:text-white hover:bg-white/10' }} transition-all duration-300">
                    <span class="text-xs font-mono">@</span> Messages
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="admin-nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.profile.*') ? 'bg-white/15 text-[#D4AF37]' : 'text-white/70 hover:text-white hover:bg-white/10' }} transition-all duration-300">
                    <span class="text-xs font-mono">&</span> Profile & CV
                </a>
            </nav>
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-full bg-[#D4AF37] flex items-center justify-center text-xs font-bold text-[#121212]">L</div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-white/40">Admin</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-sm text-white/60 hover:text-[#D4AF37] hover:bg-white/5 rounded-xl transition-all duration-300 text-left">
                        &larr; Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64">
            <!-- Top bar -->
            <header class="sticky top-0 z-30 bg-[#121212]/90 backdrop-blur-lg border-b border-[#2A2A2A] px-8 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-white">{{ $title ?? 'Dashboard' }}</h2>
                    <a href="{{ route('home') }}" target="_blank" class="text-sm text-gray-400 hover:text-[#D4AF37] transition-colors duration-300">View Site &rarr;</a>
                </div>
            </header>

            <div class="p-8">
                <!-- Flash message -->
                @if(session('success'))
                <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
