<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-100 leading-tight">{{ __('Edit Testimonial') }}</h2>
            <a href="{{ route('admin.testimonials.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-100 hover:bg-slate-50 text-xs font-semibold rounded-lg transition">← Back</a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 max-w-2xl mx-auto">
        <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $testimonial->name) }}" required class="w-full text-sm rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="rating" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Rating (1 to 5)</label>
                    <input type="number" step="0.5" min="1" max="5" name="rating" id="rating" value="{{ old('rating', $testimonial->rating) }}" required class="w-full text-sm rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    @error('rating') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Change Image (Optional)</label>
                    <input type="file" name="image" id="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    @error('image') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            @if($testimonial->image)
                <div class="flex items-center space-x-3 pt-2">
                    <span class="text-xs font-bold text-slate-400 uppercase">Current Image:</span>
                    <img src="{{ asset($testimonial->image) }}" class="w-10 h-10 rounded-full object-cover border border-slate-200" alt="Current image">
                </div>
            @endif

            <div>
                <label for="message" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Message</label>
                <textarea name="message" id="message" rows="4" required class="w-full text-sm rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">{{ old('message', $testimonial->message) }}</textarea>
                @error('message') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-2 text-right">
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">Update Testimonial</button>
            </div>
        </form>
    </div>
</x-admin-layout>