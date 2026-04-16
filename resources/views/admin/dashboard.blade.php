@extends('layouts.admin', ['title' => 'Dashboard'])

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl p-6 hover:border-[#D4AF37]/20 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-mono font-bold text-[#D4AF37]">PRJ</span>
            <span class="text-xs text-gray-500 font-mono">PROJECTS</span>
        </div>
        <p class="text-3xl font-bold text-white">{{ $stats['projects'] }}</p>
    </div>
    <div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl p-6 hover:border-[#D4AF37]/20 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-mono font-bold text-[#D4AF37]">SKL</span>
            <span class="text-xs text-gray-500 font-mono">SKILLS</span>
        </div>
        <p class="text-3xl font-bold text-white">{{ $stats['skills'] }}</p>
    </div>
    <div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl p-6 hover:border-[#D4AF37]/20 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-mono font-bold text-[#D4AF37]">MSG</span>
            <span class="text-xs text-gray-500 font-mono">MESSAGES</span>
        </div>
        <p class="text-3xl font-bold text-white">{{ $stats['messages'] }}</p>
        @if($stats['unread_messages'] > 0)
        <p class="text-xs text-[#D4AF37] mt-1">{{ $stats['unread_messages'] }} unread</p>
        @endif
    </div>
    <div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl p-6 hover:border-[#D4AF37]/20 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-mono font-bold text-[#D4AF37]">ACH</span>
            <span class="text-xs text-gray-500 font-mono">ACHIEVEMENTS</span>
        </div>
        <p class="text-3xl font-bold text-white">{{ $stats['achievements'] }}</p>
    </div>
    <div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl p-6 hover:border-[#D4AF37]/20 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-mono font-bold text-[#D4AF37]">CRT</span>
            <span class="text-xs text-gray-500 font-mono">CERTIFICATES</span>
        </div>
        <p class="text-3xl font-bold text-white">{{ $stats['certificates'] }}</p>
    </div>
    <div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl p-6 hover:border-[#D4AF37]/20 transition-all duration-300">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-mono font-bold text-[#D4AF37]">ACT</span>
            <span class="text-xs text-gray-500 font-mono">ACTIVITIES</span>
        </div>
        <p class="text-3xl font-bold text-white">{{ $stats['activities'] }}</p>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid lg:grid-cols-2 gap-6">
    <!-- Recent Messages -->
    <div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-white">Recent Messages</h3>
            <a href="{{ route('admin.messages') }}" class="text-xs text-[#D4AF37] hover:underline">View all &rarr;</a>
        </div>
        <div class="space-y-3">
            @forelse($recentMessages as $msg)
            <div class="flex items-start gap-3 p-3 rounded-xl {{ $msg->is_read ? 'bg-[#121212]/50' : 'bg-[#D4AF37]/5 border border-[#D4AF37]/10' }}">
                <div class="w-8 h-8 rounded-full bg-[#7A1C1C] flex items-center justify-center text-xs font-bold text-white shrink-0">
                    {{ strtoupper(substr($msg->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ $msg->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $msg->message }}</p>
                    <p class="text-xs text-gray-600 mt-1">{{ $msg->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <p class="text-gray-600 text-sm text-center py-4">No messages yet</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-white">Recent Projects</h3>
            <a href="{{ route('projects.index') }}" class="text-xs text-[#D4AF37] hover:underline">View all &rarr;</a>
        </div>
        <div class="space-y-3">
            @forelse($recentProjects as $project)
            <div class="flex items-center gap-3 p-3 rounded-xl bg-[#121212]/50">
                <div class="w-10 h-10 rounded-xl bg-[#7A1C1C]/20 flex items-center justify-center text-xs font-mono font-bold text-[#D4AF37]">PRJ</div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ $project->title }}</p>
                    <p class="text-xs text-gray-500">{{ $project->tech_stack ?? 'No tech stack' }}</p>
                </div>
                <a href="{{ route('projects.edit', $project) }}" class="ml-auto text-xs text-gray-500 hover:text-[#D4AF37] transition-colors duration-300">Edit</a>
            </div>
            @empty
            <p class="text-gray-600 text-sm text-center py-4">No projects yet</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
