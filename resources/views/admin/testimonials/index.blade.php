<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-100 leading-tight">
            {{ __('Testimonials') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-4 text-sm font-medium flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h3 class="text-base font-semibold text-slate-800">Testimonials List</h3>
                <p class="text-xs text-slate-500 mt-0.5">Manage customer reviews and feedback</p>
            </div>
            <div>
                <a href="{{ route('admin.testimonials.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition inline-block">
                    + Add Testimonial
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-6">User</th>
                        <th class="py-3.5 px-6">Rating</th>
                        <th class="py-3.5 px-6">Message</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($testimonials as $testimonial)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 font-semibold text-slate-800">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ asset($testimonial->image) }}" class="w-9 h-9 rounded-full object-cover border border-slate-200" alt="{{ $testimonial->name }}">
                                    <span>{{ $testimonial->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                    ★ {{ $testimonial->rating }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-600 text-xs max-w-xs truncate">{{ $testimonial->message }}</td>
                            <td class="py-4 px-6 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.testimonials.show', $testimonial->id) }}" class="inline-block px-3 py-1.5 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-medium rounded-lg transition">View</a>
                                <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="inline-block px-3 py-1.5 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-medium rounded-lg transition">Edit</a>
                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-medium rounded-lg transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400 text-xs">No testimonials found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    </div>
</x-admin-layout>