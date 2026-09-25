<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Monitoring Requests') }}
        </h2>
    </x-slot>

    <!-- DataTables CSS CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <style>
        /* DataTables aur Tailwind styling adjustments */
        .dataTables_wrapper {
            color: #334155;
        }
        .dataTables_wrapper .dataTables_length select, 
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #cbd5e1;
            border-radius: 0.375rem;
            padding: 0.3rem 0.6rem;
            outline: none;
            background-color: #ffffff;
            color: #0f172a !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #2563eb !important;
            color: white !important;
            border: 1px solid #2563eb !important;
            border-radius: 0.375rem;
        }
        /* Table rows ke darmiyan light grey border line */
        #monitoringTable tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }
    </style>

    <!-- Full width container -->
    <div class="w-full">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-base font-semibold text-slate-800">All Monitoring Requests</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Track and manage property inspection and monitoring requests</p>
                </div>
            </div>

            <div class="p-6">
                <table id="monitoringTable" class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th scope="col" class="px-6 py-3.5">ID</th>
                            <th scope="col" class="px-6 py-3.5">Property</th>
                            <th scope="col" class="px-6 py-3.5">Requester</th>
                            <th scope="col" class="px-6 py-3.5">Status</th>
                            <th scope="col" class="px-6 py-3.5">Assigned Inspector</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100 text-sm">
                        @foreach ($monitoringRequests as $request)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-500">#{{ $request->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">
                                    <a href="{{ route('admin.properties.show', $request->property) }}" class="text-indigo-600 hover:text-indigo-900 transition">{{ $request->property->title ?? 'N/A' }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600 text-xs">
                                    {{ $request->renter ? $request->renter->name : ($request->vendor->name ?? 'N/A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $status = strtolower($request->status);
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold 
                                        {{ in_array($status, ['approved', 'completed']) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 
                                           (in_array($status, ['rejected', 'cancelled']) ? 'bg-rose-50 text-rose-700 border border-rose-200/60' : 'bg-amber-50 text-amber-700 border border-amber-200/60') }}">
                                        <span class="w-1.5 h-1.5 mr-1.5 {{ in_array($status, ['approved', 'completed']) ? 'bg-emerald-500' : (in_array($status, ['rejected', 'cancelled']) ? 'bg-rose-500' : 'bg-amber-500') }} rounded-full"></span> 
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600 text-xs">
                                    @if($request->assignedInspector)
                                        <span class="font-medium text-slate-800">{{ $request->assignedInspector->name }}</span>
                                    @else
                                        <span class="text-slate-400 italic">Not Assigned</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('admin.monitoring-requests.show', $request) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-medium text-xs rounded-md transition shadow-sm">
                                        Review / Assign
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- jQuery & DataTables JS CDNs -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#monitoringTable').DataTable({
                "responsive": true,
                "pageLength": 10,
                "language": {
                    "search": "Search requests:",
                    "lengthMenu": "Show _MENU_ entries"
                }
            });
        });
    </script>
</x-admin-layout>