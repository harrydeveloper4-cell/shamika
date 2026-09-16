<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-100 leading-tight">
            {{ __('System Configurations') }}
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
                <h3 class="text-base font-semibold text-slate-800">Configurations List</h3>
                <p class="text-xs text-slate-500 mt-0.5">Manage key-value settings for your system</p>
            </div>
            <div>
                <a href="{{ route('admin.config.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition inline-block">
                    + Add Config
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-6">ID</th>
                        <th class="py-3.5 px-6">Key</th>
                        <th class="py-3.5 px-6">Type</th>
                        <th class="py-3.5 px-6">Value</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($configs as $config)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 text-slate-500 text-xs">#{{ $config->id }}</td>
                            <td class="py-4 px-6 font-semibold text-slate-800">{{ $config->key }}</td>
                            <td class="py-4 px-6 text-xs uppercase font-bold text-slate-500">{{ $config->type }}</td>
                            <td class="py-4 px-6 text-slate-600 text-xs truncate max-w-xs">
                                @if($config->type == 'image')
                                    <img src="{{ asset($config->value) }}" class="w-10 h-10 object-cover rounded-md border border-slate-200">
                                @else
                                    {{ $config->value }}
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.config.show', $config->id) }}" class="inline-block px-3 py-1.5 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-medium rounded-lg transition">View</a>
                                <a href="{{ route('admin.config.edit', $config->id) }}" class="inline-block px-3 py-1.5 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-medium rounded-lg transition">Edit</a>
                                <form action="{{ route('admin.config.destroy', $config->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-medium rounded-lg transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400 text-xs">No configs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-admin-layout>