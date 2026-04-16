@extends('layouts.app')

@section('content')
{{-- HERO SECTION --}}
<section id="hero" class="relative min-h-screen flex items-center z-10 overflow-hidden">
    {{-- Physics container --}}
    <div id="hero-physics-container" class="absolute inset-0 z-0"></div>

    {{-- Flowing shapes background decoration --}}
    <div class="absolute inset-0 z-[1] pointer-events-none overflow-hidden">
        <img src="{{ asset('images/hero/flowing-shapes.png') }}" alt="" class="absolute top-0 left-0 w-full h-full object-cover opacity-20 hero-shapes-flow" aria-hidden="true">
        {{-- Ambient glow spots --}}
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-[#7A1C1C]/8 rounded-full blur-[120px] animate-glow-pulse"></div>
        <div class="absolute bottom-1/3 right-1/4 w-80 h-80 bg-[#D4AF37]/6 rounded-full blur-[100px] animate-glow-pulse-delayed"></div>
    </div>

    {{-- Floating botanical petals (CSS animated) --}}
    <div class="absolute inset-0 z-[2] pointer-events-none overflow-hidden" aria-hidden="true">
        <div class="floating-petal petal-1"></div>
        <div class="floating-petal petal-2"></div>
        <div class="floating-petal petal-3"></div>
        <div class="floating-petal petal-4"></div>
        <div class="floating-petal petal-5"></div>
    </div>

    {{-- Main hero content — split layout: text left, photo right --}}
    <div class="relative z-10 w-full max-w-6xl mx-auto px-6 md:px-12 pt-24">
        <div class="flex flex-col-reverse md:flex-row items-center gap-10 md:gap-16">

            {{-- LEFT: Text content --}}
            <div class="flex-1 text-center md:text-left animate-fade-in-up">
                {{-- Subtitle badge --}}
                <div class="flex items-center justify-center md:justify-start gap-2 mb-6">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-[#D4AF37]/20 bg-[#D4AF37]/5 backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] animate-pulse"></span>
                        <span class="text-xs font-mono text-[#D4AF37] tracking-widest uppercase">AI & Data Science Enthusiast</span>
                    </span>
                </div>

                {{-- Name with elegant serif styling --}}
                <h1 class="text-5xl md:text-6xl lg:text-7xl mb-6 leading-tight" style="font-family: 'Playfair Display', serif;">
                    <span class="block text-white glow-text hero-name-animate font-black italic" style="letter-spacing: -0.02em;">Laura Marcella</span>
                    <span class="block bg-gradient-to-r from-[#7A1C1C] via-[#D4AF37] to-[#7A1C1C] bg-clip-text text-transparent glow-text hero-name-animate hero-name-delay font-black italic" style="letter-spacing: -0.02em;">Pratama</span>
                </h1>

                <p class="text-lg md:text-xl text-gray-400 mb-10 max-w-lg leading-relaxed font-light">
                    Turning data into <span class="text-[#D4AF37] font-medium">insights</span> and building 
                    <span class="text-[#F5E6D3] font-medium">intelligent systems</span> that solve real-world problems.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4">
                    <a href="#projects" class="btn-primary group/btn flex items-center gap-2">
                        Explore My Projects
                        <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ route('download.cv') }}" class="btn-outline group/btn flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Download CV
                    </a>
                </div>
            </div>

            {{-- RIGHT: Profile Photo with glow ring --}}
            <div class="flex-shrink-0 animate-fade-in-up" style="animation-delay: 0.3s;">
                <div class="relative group">
                    {{-- Outer glow ring --}}
                    <div class="absolute -inset-4 rounded-full bg-gradient-to-tr from-[#7A1C1C]/40 via-[#D4AF37]/30 to-[#7A1C1C]/40 blur-xl opacity-50 group-hover:opacity-100 transition-opacity duration-700 animate-spin-slow"></div>
                    {{-- Gold border ring --}}
                    <div class="relative w-56 h-56 md:w-72 md:h-72 lg:w-80 lg:h-80 rounded-full p-[3px] bg-gradient-to-tr from-[#D4AF37] via-[#F5E6D3] to-[#D4AF37] shadow-[0_0_60px_rgba(212,175,55,0.2)]">
                        <div class="w-full h-full rounded-full overflow-hidden bg-[#121212]">
                            @if($profile && $profile->photo)
                                <img src="{{ asset('storage/' . $profile->photo) }}" alt="{{ $profile->name ?? 'Laura Marcella Pratama' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <img src="{{ asset('images/hero/profile-placeholder.png') }}" alt="Laura Marcella Pratama" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Animated botanical flowers at the bottom — canvas-based --}}
    <div class="absolute bottom-0 left-0 right-0 z-[5] pointer-events-none" style="height: 25vh;">
        <canvas id="flower-canvas" class="w-full h-full"></canvas>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 animate-bounce z-20">
        <div class="w-6 h-10 rounded-full border-2 border-[#D4AF37]/40 flex items-start justify-center p-1.5 backdrop-blur-sm bg-black/20">
            <div class="w-1.5 h-3 bg-[#D4AF37] rounded-full animate-scroll-dot"></div>
        </div>
    </div>
</section>

{{-- ABOUT SECTION — Cream background --}}
<section id="about" class="relative z-10 py-24 px-6 section-cream">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16 section-animate">
            <p class="text-sm font-mono text-[#7A1C1C] mb-3 tracking-widest">// ABOUT ME</p>
            <h2 class="text-4xl md:text-5xl font-outfit font-bold text-[#121212]">Who I Am</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="section-animate">
                <p class="text-[#3A3A3A] text-lg leading-relaxed mb-8">
                    {{ $profile->bio ?? 'Computer Science student at BINUS University (GPA 3.8) focusing on Artificial Intelligence, data analysis, and backend systems.' }}
                </p>
                <div class="flex flex-wrap gap-3">
                    <span class="px-4 py-2 rounded-xl bg-[#7A1C1C]/10 border border-[#7A1C1C]/20 text-[#7A1C1C] text-sm font-medium">BINUS University</span>
                    <span class="px-4 py-2 rounded-xl bg-[#D4AF37]/10 border border-[#D4AF37]/20 text-[#7A1C1C] text-sm font-medium">GPA 3.8</span>
                    <span class="px-4 py-2 rounded-xl bg-[#7A1C1C]/10 border border-[#7A1C1C]/20 text-[#7A1C1C] text-sm font-medium">Malang, Indonesia</span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 section-animate">
                <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-[#E8D5BF]">
                    <div class="text-2xl mb-3 text-[#D4AF37] font-mono font-bold">+</div>
                    <h3 class="font-semibold text-[#121212] mb-1 text-sm">AI Healthcare</h3>
                    <p class="text-[#666] text-xs">Hackathon Participant</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-[#E8D5BF]">
                    <div class="text-2xl mb-3 text-[#7A1C1C] font-mono font-bold">#</div>
                    <h3 class="font-semibold text-[#121212] mb-1 text-sm">Data Competition</h3>
                    <p class="text-[#666] text-xs">National Finalist</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-[#E8D5BF]">
                    <div class="text-2xl mb-3 text-[#D4AF37] font-mono font-bold">&gt;</div>
                    <h3 class="font-semibold text-[#121212] mb-1 text-sm">Teaching Assistant</h3>
                    <p class="text-[#666] text-xs">C, Python, DS, HCI</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-[#E8D5BF]">
                    <div class="text-2xl mb-3 text-[#7A1C1C] font-mono font-bold">*</div>
                    <h3 class="font-semibold text-[#121212] mb-1 text-sm">AI Research</h3>
                    <p class="text-[#666] text-xs">ML & Deep Learning</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SKILLS SECTION — Dark --}}
<section id="skills" class="relative z-10 py-24 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16 section-animate">
            <p class="text-sm font-mono text-[#D4AF37] mb-3 tracking-widest">// AI & DATA SKILLS</p>
            <h2 class="text-4xl md:text-5xl font-outfit font-bold text-white">Technical Arsenal</h2>
        </div>

        <!-- Neural Network Visualization -->
        <div class="relative mb-16 section-animate">
            <canvas id="neural-canvas" class="w-full h-64 md:h-80 rounded-2xl"></canvas>
        </div>

        <!-- Skill Categories -->
        <div class="grid md:grid-cols-3 gap-8">
            @foreach(['AI' => ['icon' => 'AI', 'label' => 'AI & Machine Learning'], 'Web' => ['icon' => 'WEB', 'label' => 'Web Development'], 'Tools' => ['icon' => 'DEV', 'label' => 'Tools & Platforms']] as $category => $meta)
            <div class="section-animate glass-card p-6">
                <div class="flex items-center gap-3 mb-6">
                    <span class="text-xs font-mono font-bold px-2.5 py-1 rounded-lg bg-[#D4AF37]/15 text-[#D4AF37]">{{ $meta['icon'] }}</span>
                    <h3 class="font-outfit font-bold text-lg text-white">{{ $meta['label'] }}</h3>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($skills[$category] ?? [] as $skill)
                    <span class="skill-node px-3 py-1.5 text-sm rounded-lg bg-white/5 border border-white/10 text-gray-300 hover:bg-[#D4AF37]/10 hover:border-[#D4AF37]/20 hover:text-[#D4AF37] transition-all cursor-default">
                        {{ $skill->name }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PROJECTS SECTION — Cream --}}
<section id="projects" class="relative z-10 py-24 px-6 section-cream">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16 section-animate">
            <p class="text-sm font-mono text-[#7A1C1C] mb-3 tracking-widest">// MY WORK</p>
            <h2 class="text-4xl md:text-5xl font-outfit font-bold text-[#121212]">Featured Projects</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-8" id="projects-grid">
            @foreach($projects as $project)
            <div class="section-animate project-card bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl cursor-pointer group border border-[#E8D5BF]" data-project-id="{{ $project->id }}" onclick="openProjectModal({{ $project->id }})">
                @if($project->image)
                <div class="h-48 overflow-hidden relative">
                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @if($project->demo_video)
                    <div class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="w-12 h-12 rounded-full bg-[#7A1C1C] flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>
                    @endif
                </div>
                @else
                <div class="h-48 bg-gradient-to-br from-[#7A1C1C]/10 via-[#D4AF37]/10 to-[#7A1C1C]/5 flex items-center justify-center">
                    <div class="text-4xl opacity-20 font-mono text-[#7A1C1C]">&lt;/&gt;</div>
                </div>
                @endif
                <div class="p-6">
                    <h3 class="font-outfit font-bold text-xl text-[#121212] mb-2 group-hover:text-[#7A1C1C] transition-colors duration-300">{{ $project->title }}</h3>
                    <p class="text-[#666] text-sm mb-4 line-clamp-2">{{ $project->description }}</p>
                    @if($project->tech_stack)
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $project->tech_stack) as $tech)
                        <span class="px-2 py-1 text-xs rounded-md bg-[#F5E6D3] text-[#7A1C1C] border border-[#E8D5BF]">{{ trim($tech) }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Project Modal --}}
<div id="project-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-md" onclick="closeProjectModal()"></div>
    <div class="relative bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto p-8 animate-modal-in">
        <button onclick="closeProjectModal()" class="absolute top-4 right-4 text-gray-500 hover:text-white text-2xl">&times;</button>
        <div id="modal-content"></div>
    </div>
</div>

{{-- EXPERIENCE SECTION — Dark with Parallax --}}
<section id="experience" class="relative z-10 py-24 px-6 overflow-hidden">
    {{-- Parallax background layers --}}
    <div class="parallax-bg absolute inset-0 pointer-events-none" data-parallax-speed="0.15">
        <div class="absolute top-20 left-10 w-72 h-72 bg-[#7A1C1C]/6 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-40 right-20 w-96 h-96 bg-[#D4AF37]/5 rounded-full blur-[120px]"></div>
    </div>
    <div class="parallax-bg absolute inset-0 pointer-events-none" data-parallax-speed="0.08">
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-[#D4AF37]/4 rounded-full blur-[80px]"></div>
    </div>

    <div class="max-w-6xl mx-auto relative">
        <div class="text-center mb-20 section-animate">
            <p class="text-sm font-mono text-[#D4AF37] mb-3 tracking-widest">// EXPERIENCE</p>
            <h2 class="text-4xl md:text-5xl font-outfit font-bold text-white">Leadership & Teaching</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-[#7A1C1C] via-[#D4AF37] to-[#7A1C1C] mx-auto mt-6 rounded-full"></div>
        </div>

        <div class="space-y-24 md:space-y-32">
            @foreach($experiences as $index => $exp)
            <div class="section-animate experience-parallax-row" data-parallax-speed="{{ $index % 2 === 0 ? '0.05' : '-0.05' }}">
                <div class="flex flex-col {{ $index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' }} items-center gap-8 md:gap-16">

                    {{-- DESCRIPTION SIDE --}}
                    <div class="flex-1 w-full">
                        <div class="experience-desc-card relative p-8 rounded-2xl border border-[#2A2A2A]/60 backdrop-blur-md overflow-hidden group"
                             style="background: linear-gradient(135deg, rgba(30,30,30,0.9) 0%, rgba(18,18,18,0.95) 100%);">
                            {{-- Decorative corner accent --}}
                            <div class="absolute top-0 {{ $index % 2 === 0 ? 'left-0' : 'right-0' }} w-20 h-20 opacity-20 pointer-events-none">
                                <div class="absolute top-0 {{ $index % 2 === 0 ? 'left-0 border-l-2 border-t-2' : 'right-0 border-r-2 border-t-2' }} border-[#D4AF37] w-full h-full rounded-tl-2xl"></div>
                            </div>

                            {{-- Year badge --}}
                            <div class="inline-flex items-center gap-2 mb-5">
                                <span class="w-2 h-2 rounded-full bg-[#D4AF37] animate-pulse"></span>
                                <span class="text-xs font-mono text-[#D4AF37] tracking-widest uppercase bg-[#D4AF37]/10 px-3 py-1 rounded-full border border-[#D4AF37]/20">{{ $exp->year }}</span>
                            </div>

                            <h3 class="font-outfit font-bold text-2xl md:text-3xl text-white mb-2 group-hover:text-[#D4AF37] transition-colors duration-500">{{ $exp->title }}</h3>
                            <p class="text-[#F5E6D3] font-medium text-base mb-5 flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ $exp->role }}
                            </p>
                            <p class="text-gray-400 leading-relaxed text-base">{{ $exp->description }}</p>

                            {{-- Hover glow bar at bottom --}}
                            <div class="absolute bottom-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-[#D4AF37]/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        </div>
                    </div>

                    {{-- PHOTO SIDE --}}
                    <div class="flex-1 w-full flex {{ $index % 2 === 0 ? 'justify-end' : 'justify-start' }}">
                        <div class="experience-photo-wrapper relative w-full max-w-md group">
                            {{-- Floating frame decoration --}}
                            <div class="absolute -inset-3 rounded-2xl border border-[#D4AF37]/15 opacity-0 group-hover:opacity-100 transition-all duration-700 {{ $index % 2 === 0 ? 'translate-x-2 translate-y-2' : '-translate-x-2 translate-y-2' }} group-hover:translate-x-0 group-hover:translate-y-0"></div>

                            {{-- Glow behind image --}}
                            <div class="absolute -inset-4 bg-gradient-to-br {{ $index % 2 === 0 ? 'from-[#7A1C1C]/20 to-[#D4AF37]/10' : 'from-[#D4AF37]/10 to-[#7A1C1C]/20' }} rounded-2xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                            <div class="relative aspect-[4/3] rounded-2xl overflow-hidden border border-[#2A2A2A] shadow-2xl shadow-black/40">
                                @if($exp->image)
                                <img src="{{ asset('storage/' . $exp->image) }}" alt="{{ $exp->title }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                                @else
                                <div class="w-full h-full bg-gradient-to-br from-[#1E1E1E] via-[#2A2A2A] to-[#1E1E1E] flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="text-4xl mb-3 opacity-20">{{ $index % 2 === 0 ? '🎓' : '💡' }}</div>
                                        <span class="text-gray-600 text-sm font-mono">{{ $exp->title }}</span>
                                    </div>
                                </div>
                                @endif

                                {{-- Overlay gradient --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                                {{-- Index number overlay --}}
                                <div class="absolute bottom-4 {{ $index % 2 === 0 ? 'right-4' : 'left-4' }} text-5xl font-outfit font-black text-white/5 group-hover:text-[#D4AF37]/15 transition-colors duration-500">
                                    0{{ $index + 1 }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ACHIEVEMENTS SECTION — Cream --}}
<section id="achievements" class="relative z-10 py-24 px-6 section-cream">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16 section-animate">
            <p class="text-sm font-mono text-[#7A1C1C] mb-3 tracking-widest">// ACHIEVEMENTS</p>
            <h2 class="text-4xl md:text-5xl font-outfit font-bold text-[#121212]">Awards & Recognition</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($achievements as $achievement)
            <div class="section-animate bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg text-center group achievement-card border border-[#E8D5BF]">
                <div class="text-3xl mb-4 font-mono text-[#D4AF37]">&#9733;</div>
                <h3 class="font-outfit font-bold text-[#121212] mb-2 text-sm">{{ $achievement->title }}</h3>
                <p class="text-[#666] text-xs mb-3">{{ $achievement->description }}</p>
                <span class="text-xs font-mono text-[#7A1C1C] font-semibold">{{ $achievement->year }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CERTIFICATES SECTION — Dark --}}
<section id="certificates" class="relative z-10 py-24 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16 section-animate">
            <p class="text-sm font-mono text-[#D4AF37] mb-3 tracking-widest">// CERTIFICATIONS</p>
            <h2 class="text-4xl md:text-5xl font-outfit font-bold text-white">Certificates</h2>
        </div>
        @if($certificates->count() > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($certificates as $cert)
            <div class="section-animate glass-card rounded-2xl overflow-hidden hover-glow group cursor-pointer" onclick="openCertModal('{{ asset('storage/' . $cert->image) }}', '{{ addslashes($cert->name) }}')">
                <div class="h-52 overflow-hidden">
                    <img src="{{ asset('storage/' . $cert->image) }}" alt="{{ $cert->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h3 class="font-outfit font-semibold text-white text-sm group-hover:text-[#D4AF37] transition-colors duration-300">{{ $cert->name }}</h3>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="section-animate text-center py-16">
            <div class="glass-card inline-block px-12 py-10 rounded-2xl">
                <div class="text-5xl mb-4 opacity-30">📜</div>
                <p class="text-gray-400 text-lg font-outfit">Certificates coming soon</p>
                <p class="text-gray-600 text-sm mt-2">Stay tuned for my professional certifications!</p>
            </div>
        </div>
        @endif
    </div>
</section>

{{-- Certificate Lightbox Modal --}}
<div id="cert-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6">
    <div class="absolute inset-0 bg-black/90 backdrop-blur-md" onclick="closeCertModal()"></div>
    <div class="relative max-w-4xl w-full animate-modal-in">
        <button onclick="closeCertModal()" class="absolute -top-10 right-0 text-gray-400 hover:text-white text-2xl">&times;</button>
        <img id="cert-modal-img" src="" alt="" class="w-full rounded-2xl shadow-2xl">
        <p id="cert-modal-name" class="text-center text-white font-outfit font-semibold mt-4"></p>
    </div>
</div>

{{-- ACTIVITY PHOTOS SECTION — Cream --}}
<section id="activities" class="relative z-10 py-24 px-6 section-cream">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16 section-animate">
            <p class="text-sm font-mono text-[#7A1C1C] mb-3 tracking-widest">// GALLERY</p>
            <h2 class="text-4xl md:text-5xl font-outfit font-bold text-[#121212]">Activities & Events</h2>
        </div>
        @if($activityPhotos->count() > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($activityPhotos as $photo)
            <div class="section-animate bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg group border border-[#E8D5BF] cursor-pointer" onclick="openCertModal('{{ asset('storage/' . $photo->image) }}', '{{ addslashes($photo->title ?? '') }}')">
                <div class="h-56 overflow-hidden">
                    <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                @if($photo->title || $photo->description)
                <div class="p-4">
                    @if($photo->title)
                    <h3 class="font-outfit font-semibold text-[#121212] text-sm mb-1 group-hover:text-[#7A1C1C] transition-colors duration-300">{{ $photo->title }}</h3>
                    @endif
                    @if($photo->description)
                    <p class="text-[#666] text-xs">{{ Str::limit($photo->description, 100) }}</p>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="section-animate text-center py-16">
            <div class="inline-block px-12 py-10 rounded-2xl bg-white border border-[#E8D5BF] shadow-sm">
                <div class="text-5xl mb-4 opacity-30">📸</div>
                <p class="text-[#3A3A3A] text-lg font-outfit">Activity photos coming soon</p>
                <p class="text-[#999] text-sm mt-2">Check back to see highlights from events & activities!</p>
            </div>
        </div>
        @endif
    </div>
</section>

{{-- CONTACT SECTION — Dark --}}
<section id="contact" class="relative z-10 py-24 px-6">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-16 section-animate">
            <p class="text-sm font-mono text-[#D4AF37] mb-3 tracking-widest">// GET IN TOUCH</p>
            <h2 class="text-4xl md:text-5xl font-outfit font-bold text-white">Let's Connect</h2>
        </div>
        <form action="{{ route('contact.send') }}" method="POST" class="glass-card p-8 section-animate space-y-6">
            @csrf
            <div>
                <label for="contact-name" class="block text-sm font-medium text-gray-400 mb-2">Name</label>
                <input type="text" id="contact-name" name="name" required
                    class="w-full px-4 py-3 bg-[#121212] border border-[#2A2A2A] rounded-xl text-white placeholder-gray-600 focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 focus:shadow-[0_0_15px_rgba(212,175,55,0.1)] transition-all outline-none"
                    placeholder="Your name">
            </div>
            <div>
                <label for="contact-email" class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                <input type="email" id="contact-email" name="email" required
                    class="w-full px-4 py-3 bg-[#121212] border border-[#2A2A2A] rounded-xl text-white placeholder-gray-600 focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 focus:shadow-[0_0_15px_rgba(212,175,55,0.1)] transition-all outline-none"
                    placeholder="your@email.com">
            </div>
            <div>
                <label for="contact-message" class="block text-sm font-medium text-gray-400 mb-2">Message</label>
                <textarea id="contact-message" name="message" rows="5" required
                    class="w-full px-4 py-3 bg-[#121212] border border-[#2A2A2A] rounded-xl text-white placeholder-gray-600 focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37]/30 focus:shadow-[0_0_15px_rgba(212,175,55,0.1)] transition-all outline-none resize-none"
                    placeholder="Tell me about your project or just say hi..."></textarea>
            </div>
            <button type="submit" class="w-full btn-primary">
                Send Message
            </button>
        </form>
    </div>
</section>

{{-- Project data for modals --}}
<script>
const projectsData = @json($projects);

function openProjectModal(id) {
    const project = projectsData.find(p => p.id === id);
    if (!project) return;
    
    const modal = document.getElementById('project-modal');
    const content = document.getElementById('modal-content');
    
    // Build video player HTML if demo_video exists
    const videoHtml = project.demo_video ? `
        <div class="mb-6">
            <h4 class="text-sm font-mono text-[#D4AF37] mb-3">// DEMO VIDEO</h4>
            <div class="rounded-xl overflow-hidden bg-black">
                <video controls class="w-full rounded-xl" preload="metadata" style="max-height: 400px;">
                    <source src="/storage/${project.demo_video}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>` : '';

    content.innerHTML = `
        <h2 class="text-2xl font-outfit font-bold text-white mb-4">${project.title}</h2>
        <p class="text-gray-400 mb-6">${project.description || ''}</p>
        ${videoHtml}
        ${project.problem ? `
        <div class="mb-4">
            <h4 class="text-sm font-mono text-[#D4AF37] mb-2">// PROBLEM</h4>
            <p class="text-gray-300 text-sm">${project.problem}</p>
        </div>` : ''}
        ${project.approach ? `
        <div class="mb-4">
            <h4 class="text-sm font-mono text-[#F5E6D3] mb-2">// APPROACH</h4>
            <p class="text-gray-300 text-sm">${project.approach}</p>
        </div>` : ''}
        ${project.result ? `
        <div class="mb-4">
            <h4 class="text-sm font-mono text-[#D4AF37] mb-2">// RESULT</h4>
            <p class="text-gray-300 text-sm">${project.result}</p>
        </div>` : ''}
        ${project.tech_stack ? `
        <div class="mb-6">
            <h4 class="text-sm font-mono text-[#F5E6D3] mb-2">// TECH STACK</h4>
            <div class="flex flex-wrap gap-2">
                ${project.tech_stack.split(',').map(t => `<span class="px-3 py-1 text-xs rounded-lg bg-[#2A2A2A] text-gray-300 border border-[#333]">${t.trim()}</span>`).join('')}
            </div>
        </div>` : ''}
        <div class="flex gap-4">
            ${project.github_link ? `<a href="${project.github_link}" target="_blank" class="px-6 py-2.5 rounded-xl bg-[#2A2A2A] border border-[#333] text-white hover:border-[#D4AF37] hover:text-[#D4AF37] transition-all text-sm font-medium">GitHub &rarr;</a>` : ''}
            ${project.demo_link ? `<a href="${project.demo_link}" target="_blank" class="btn-primary text-sm !py-2.5 !px-6">Live Demo &rarr;</a>` : ''}
        </div>
    `;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeProjectModal() {
    const modal = document.getElementById('project-modal');
    // Stop any playing videos
    const videos = modal.querySelectorAll('video');
    videos.forEach(v => v.pause());
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Certificate lightbox
function openCertModal(imgSrc, name) {
    const modal = document.getElementById('cert-modal');
    document.getElementById('cert-modal-img').src = imgSrc;
    document.getElementById('cert-modal-name').textContent = name;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeCertModal() {
    const modal = document.getElementById('cert-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeProjectModal();
        closeCertModal();
    }
});
</script>
@endsection
