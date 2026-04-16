<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Laura Marcella Pratama — AI & Data Science Enthusiast | Fullstack Developer. Turning data into insights and intelligent systems.">
    <meta name="keywords" content="AI, Data Science, Machine Learning, Portfolio, Laura Marcella Pratama">
    <title>Laura Marcella Pratama — AI & Data Science Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/matter-js/0.20.0/matter.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#121212] text-white font-sans antialiased overflow-x-hidden">
    <!-- Cursor glow trail -->
    <div id="cursor-glow" class="pointer-events-none fixed w-80 h-80 rounded-full opacity-0 transition-opacity duration-300 z-[9999]" style="background: radial-gradient(circle, rgba(212,175,55,0.06) 0%, transparent 70%);"></div>

    <!-- Particle Canvas Background -->
    <canvas id="particle-canvas" class="fixed inset-0 w-full h-full z-0 pointer-events-none"></canvas>

    <!-- Navigation -->
    <nav id="main-nav" class="fixed top-0 left-0 right-0 z-50 nav-maroon transition-all duration-500">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="#hero" class="text-xl font-outfit font-bold text-white">
                LMP<span class="text-[#D4AF37]">.</span>
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="#about" class="nav-link text-sm font-medium text-white/80 hover:text-[#D4AF37] transition-colors duration-300">About</a>
                <a href="#skills" class="nav-link text-sm font-medium text-white/80 hover:text-[#D4AF37] transition-colors duration-300">Skills</a>
                <a href="#projects" class="nav-link text-sm font-medium text-white/80 hover:text-[#D4AF37] transition-colors duration-300">Projects</a>
                <a href="#experience" class="nav-link text-sm font-medium text-white/80 hover:text-[#D4AF37] transition-colors duration-300">Experience</a>
                <a href="#achievements" class="nav-link text-sm font-medium text-white/80 hover:text-[#D4AF37] transition-colors duration-300">Achievements</a>
                <a href="#certificates" class="nav-link text-sm font-medium text-white/80 hover:text-[#D4AF37] transition-colors duration-300">Certificates</a>
                <a href="#activities" class="nav-link text-sm font-medium text-white/80 hover:text-[#D4AF37] transition-colors duration-300">Activities</a>
                <a href="#contact" class="nav-link text-sm font-medium text-white/80 hover:text-[#D4AF37] transition-colors duration-300">Contact</a>
            </div>
            <div class="flex items-center gap-3">
                <button id="gravity-toggle" class="px-3 py-1.5 text-xs font-mono rounded-full border border-[#D4AF37]/30 text-[#D4AF37] hover:bg-[#D4AF37]/10 transition-all duration-300" title="Toggle Gravity">
                    Gravity: ON
                </button>
                <button id="reset-layout" class="px-3 py-1.5 text-xs font-mono rounded-full border border-white/20 text-white/60 hover:bg-white/10 transition-all duration-300" title="Reset Layout">
                    Reset
                </button>
                <!-- Mobile menu toggle -->
                <button id="mobile-menu-btn" class="md:hidden text-white/80 hover:text-[#D4AF37]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden px-6 pb-4">
            <div class="flex flex-col gap-3 bg-[#7A1C1C]/95 backdrop-blur rounded-xl p-4 border border-[#D4AF37]/10">
                <a href="#about" class="text-sm text-white/80 hover:text-[#D4AF37] transition-colors">About</a>
                <a href="#skills" class="text-sm text-white/80 hover:text-[#D4AF37] transition-colors">Skills</a>
                <a href="#projects" class="text-sm text-white/80 hover:text-[#D4AF37] transition-colors">Projects</a>
                <a href="#experience" class="text-sm text-white/80 hover:text-[#D4AF37] transition-colors">Experience</a>
                <a href="#achievements" class="text-sm text-white/80 hover:text-[#D4AF37] transition-colors">Achievements</a>
                <a href="#certificates" class="text-sm text-white/80 hover:text-[#D4AF37] transition-colors">Certificates</a>
                <a href="#activities" class="text-sm text-white/80 hover:text-[#D4AF37] transition-colors">Activities</a>
                <a href="#contact" class="text-sm text-white/80 hover:text-[#D4AF37] transition-colors">Contact</a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative z-10 border-t border-[#2A2A2A] py-8 mt-20 bg-[#121212]">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Laura Marcella Pratama. Built with &hearts; & AI.</p>
            <div class="flex items-center gap-6">
                @if($profile->linkedin ?? false)
                <a href="{{ $profile->linkedin }}" target="_blank" class="text-gray-500 hover:text-[#D4AF37] transition-colors duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </a>
                @endif
                @if($profile->github ?? false)
                <a href="{{ $profile->github }}" target="_blank" class="text-gray-500 hover:text-[#D4AF37] transition-colors duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                </a>
                @endif
            </div>
        </div>
    </footer>

    <!-- Flash Messages -->
    @if(session('success'))
    <div id="flash-success" class="fixed bottom-6 right-6 z-[9999] bg-green-500/20 border border-green-500/30 text-green-400 px-6 py-3 rounded-xl backdrop-blur-lg animate-slide-up">
        {{ session('success') }}
    </div>
    <script>setTimeout(() => document.getElementById('flash-success')?.remove(), 4000);</script>
    @endif

    <!-- Portfolio Data for JS -->
    <script>
        window.portfolioData = {
            csrfToken: '{{ csrf_token() }}',
        };
    </script>
    @stack('scripts')
</body>
</html>
