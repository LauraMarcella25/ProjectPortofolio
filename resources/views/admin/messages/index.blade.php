@extends('layouts.admin', ['title' => 'Messages'])

@section('content')
<div class="mb-6">
    <p class="text-gray-500 text-sm">Contact form messages from visitors</p>
</div>

<div class="space-y-4">
    @forelse($messages as $msg)
    <div class="bg-[#1E1E1E] border {{ $msg->is_read ? 'border-[#2A2A2A]' : 'border-[#D4AF37]/20 bg-[#D4AF37]/5' }} rounded-2xl p-6 transition-all duration-300">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-start gap-4 min-w-0">
                <div class="w-10 h-10 rounded-full bg-[#7A1C1C] flex items-center justify-center text-sm font-bold text-white shrink-0">
                    {{ strtoupper(substr($msg->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="font-semibold text-white text-sm">{{ $msg->name }}</h3>
                        @if(!$msg->is_read)
                        <span class="px-2 py-0.5 text-xs rounded-full bg-[#D4AF37]/20 text-[#D4AF37]">New</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mb-2">{{ $msg->email }} · {{ $msg->created_at->diffForHumans() }}</p>
                    <p class="text-sm text-gray-300">{{ $msg->message }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                @if(!$msg->is_read)
                <form action="{{ route('admin.messages.read', $msg) }}" method="POST">
                    @csrf @method('PATCH')
                    <button class="text-xs text-gray-500 hover:text-[#D4AF37] transition-colors duration-300" title="Mark as read">Mark Read</button>
                </form>
                @endif
                <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                    @csrf @method('DELETE')
                    <button class="text-xs text-gray-500 hover:text-red-400 transition-colors duration-300" title="Delete">&times;</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-12 text-gray-600">
        <p class="text-4xl mb-3 text-gray-700">--</p>
        <p>No messages yet. Share your portfolio to start receiving messages!</p>
    </div>
    @endforelse
</div>
<div class="mt-4">{{ $messages->links() }}</div>
@endsection
