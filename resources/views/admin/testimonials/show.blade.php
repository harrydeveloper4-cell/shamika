<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-100 leading-tight">{{ __('Testimonial Details') }}</h2>
            <a href="{{ route('admin.testimonials.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-100 hover:bg-slate-50 text-xs font-semibold rounded-lg transition">← Back</a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl mx-auto">
        <div class="p-6 space-y-4">
            <div class="flex items-center space-x-4">
                <img src="{{ asset($testimonial->image) }}" class="w-16 h-16 rounded-full object-cover border border-slate-200 shadow-sm" alt="{{ $testimonial->name }}">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">{{ $testimonial->name }}</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200 mt-1">
                        ★ {{ $testimonial->rating }} / 5
                    </span>
                </div>
            </div>

            <div>
                <span class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Message</span>
                <div class="p-4 bg-slate-50/70 rounded-xl border border-slate-100 text-sm text-slate-700 italic">
                    "{{ $testimonial->message }}"
                </div>
            </div>
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-100 text-right space-x-2">
            <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg transition inline-block">Edit Testimonial</a>
        </div>
    </div>
</x-admin-layout>