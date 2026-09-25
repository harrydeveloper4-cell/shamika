<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('My Assigned Inspections') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 text-slate-800">
                    @if(session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2 shadow-sm">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table id="inspectionTable" class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Property</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Scheduled</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Recommendation</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse($inspections as $inspection)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">#{{ $inspection->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800">
                                            <div class="font-semibold text-slate-800">{{ $inspection->property->title ?? 'N/A' }}</div>
                                            <div class="text-slate-500 text-xs">{{ $inspection->property->address ?? '' }}, {{ $inspection->property->city ?? '' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                                {{ $inspection->status === 'Report Submitted' ? 'bg-purple-50 text-purple-700 border border-purple-100' :
                                                   ($inspection->status === 'Completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' :
                                                   ($inspection->status === 'In Progress' ? 'bg-blue-50 text-blue-700 border border-blue-100' :
                                                   ($inspection->status === 'Scheduled' ? 'bg-amber-50 text-amber-700 border border-amber-100' : 'bg-slate-100 text-slate-700'))) }}">
                                                {{ $inspection->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                            {{ $inspection->scheduled_at ? $inspection->scheduled_at->toFormattedDateString() . ' at ' . $inspection->scheduled_at->format('h:i A') : 'Not scheduled' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($inspection->recommendation === 'approve')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                    ✓ Approve
                                                </span>
                                            @elseif($inspection->recommendation === 'reject')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                                                    ✕ Reject
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                                    ⏳ Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('pm-team.inspections.show', $inspection) }}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-all duration-150">
                                                View / Manage
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 text-sm">No inspections assigned to you yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables JS & Initialization -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof jQuery !== 'undefined') {
                $(document).ready(function() {
                    $('#inspectionTable').DataTable({
                        responsive: true,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Search inspections..."
                        }
                    });
                });
            }
        });
    </script>
</x-app-layout>