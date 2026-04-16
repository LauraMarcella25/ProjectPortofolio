@extends('layouts.admin', ['title' => 'Experience'])

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">Manage leadership & teaching experience</p>
    <a href="{{ route('experiences.create') }}" class="px-4 py-2 bg-[#7A1C1C] hover:bg-[#D4AF37] hover:text-[#121212] text-white text-sm font-medium rounded-xl transition-all duration-300">+ Add Experience</a>
</div>

<div class="bg-[#1E1E1E] border border-[#2A2A2A] rounded-xl overflow-hidden">
    <table class="w-full">
        <thead class="bg-[#121212]/50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Year</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#2A2A2A]">
            @forelse($experiences as $exp)
            <tr class="hover:bg-[#121212]/30 transition-colors">
                <td class="px-6 py-4 text-sm font-medium text-white">{{ $exp->title }}</td>
                <td class="px-6 py-4 text-sm text-gray-400">{{ $exp->role ?? '—' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $exp->year ?? '—' }}</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('experiences.edit', $exp) }}" class="text-[#D4AF37] hover:text-[#E4C55A] text-sm mr-3">Edit</a>
                    <form action="{{ route('experiences.destroy', $exp) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-400 hover:text-red-300 text-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-600">No experiences yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $experiences->links() }}</div>
@endsection
