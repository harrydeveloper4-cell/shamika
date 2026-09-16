<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-100 leading-tight">{{ __('Create Config') }}</h2>
            <a href="{{ route('admin.config.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold rounded-lg transition">← Back</a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 max-w-2xl mx-auto">
        <form action="{{ route('admin.config.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="key" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Key</label>
                <input type="text" name="key" id="key" value="{{ old('key') }}" required class="w-full text-sm rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                @error('key') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="type" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Type</label>
                <select name="type" id="type_select" onchange="toggleValueInput(this.value)" class="w-full text-sm rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                    <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image</option>
                </select>
                @error('type') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div id="text_input_container">
                <label for="value_text" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Value</label>
                <textarea name="value" id="value_text" rows="4" class="w-full text-sm rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">{{ old('value') }}</textarea>
                @error('value') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div id="file_input_container" class="hidden">
                <label for="value_file" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Upload Image</label>
                <input type="file" name="value_file" id="value_file" accept="image/*" class="w-full text-sm border border-slate-200 rounded-lg p-2 focus:border-indigo-500 focus:ring-indigo-500">
                @error('value_file') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-2 text-right">
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">Save Config</button>
            </div>
        </form>
    </div>

    <script>
        function toggleValueInput(type) {
            const textContainer = document.getElementById('text_input_container');
            const fileContainer = document.getElementById('file_input_container');
            
            if (type === 'image') {
                textContainer.classList.add('hidden');
                fileContainer.classList.remove('hidden');
            } else {
                fileContainer.classList.add('hidden');
                textContainer.classList.remove('hidden');
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            toggleValueInput(document.getElementById('type_select').value);
        });
    </script>
</x-admin-layout>