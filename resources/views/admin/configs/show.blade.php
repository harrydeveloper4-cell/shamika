<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-100 leading-tight">{{ __('Config Details') }}</h2>
            <a href="{{ route('admin.config.index') }}" class="px-3.5 py-1.5 border border-slate-100 text-slate-100 hover:bg-slate-50 text-xs font-semibold rounded-lg transition">← Back</a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl mx-auto">
        <div class="p-6 space-y-4">
            <div>
                <span class="block text-xs font-bold uppercase tracking-wider text-slate-400">Type</span>
                <p class="text-sm font-semibold text-slate-700 mt-1 uppercase">{{ $config->type }}</p>
            </div>
            <div>
                <span class="block text-xs font-bold uppercase tracking-wider text-slate-400">Value</span>
                <div class="p-4 bg-slate-50/70 rounded-xl border border-slate-100 text-sm text-slate-700 mt-1">
                    @if($config->type == 'image')
                        <img src="{{ asset($config->value) }}" alt="{{ $config->key }}" class="max-w-xs h-auto rounded-lg border border-slate-200">
                    @else
                        {{ $config->value }}
                    @endif
                </div>
            </div>
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-100 text-right space-x-2">
            <a href="{{ route('admin.config.edit', $config->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg transition inline-block">Edit Config</a>
        </div>
    </div>
</x-admin-layout>