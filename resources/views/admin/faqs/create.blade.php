<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">{{ __('Create FAQ') }}</h2>
            <a href="{{ route('admin.faq.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold rounded-lg transition">← Back</a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 max-w-2xl mx-auto">
        <form action="{{ route('admin.faq.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="question" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Question</label>
                <input type="text" name="question" id="question" value="{{ old('question') }}" required class="w-full text-sm rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                @error('question') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="answer" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Answer</label>
                <textarea name="answer" id="answer" rows="5" required class="w-full text-sm rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">{{ old('answer') }}</textarea>
                @error('answer') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="pt-2 text-right">
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">Save FAQ</button>
            </div>
        </form>
    </div>
</x-admin-layout>