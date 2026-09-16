<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-100 leading-tight">
            {{ __('Inquries Management') }}
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
                <h3 class="text-base font-semibold text-slate-800">Customer Inquries</h3>
                <p class="text-xs text-slate-500 mt-0.5">View and manage form submissions from contact page</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-6">ID</th>
                        <th class="py-3.5 px-6">Name & Email</th>
                        <th class="py-3.5 px-6">Phone</th>
                        <th class="py-3.5 px-6">Subject</th>
                        <th class="py-3.5 px-6">Message</th>
                        <th class="py-3.5 px-6">Date</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($inquries as $inquiry)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 text-slate-500 text-xs">#{{ $inquiry->id }}</td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-slate-800">{{ $inquiry->name }}</div>
                                <div class="text-xs text-slate-500">{{ $inquiry->email }}</div>
                            </td>
                            <td class="py-4 px-6 text-slate-600 text-xs">{{ $inquiry->phone }}</td>
                            <td class="py-4 px-6 font-medium text-slate-700 max-w-xs truncate">{{ $inquiry->subject }}</td>
                            <td class="py-4 px-6 text-slate-600 text-xs max-w-xs truncate">
                                {{ $inquiry->message ?? 'N/A' }}
                            </td>
                            <td class="py-4 px-6 text-slate-500 text-xs whitespace-nowrap">
                                {{ $inquiry->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-4 px-6 text-right space-x-2 whitespace-nowrap">
                                <form action="{{ route('admin.inquries.destroy', $inquiry->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-medium rounded-lg transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 text-xs">No inquries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
    </div>
</x-admin-layout>