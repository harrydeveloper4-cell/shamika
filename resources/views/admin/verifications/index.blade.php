<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Verification Decisions') }}
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
        #verificationsTable tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }
    </style>

    <!-- Full width container -->
    <div class="w-full">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-base font-semibold text-slate-800">Inspections Ready for Verification Decision</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Review inspection reports submitted by inspectors and make final approval decisions</p>
                </div>
            </div>

            <div class="p-6">
                <table id="verificationsTable" class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th scope="col" class="px-6 py-3.5">Property</th>
                            <th scope="col" class="px-6 py-3.5">Vendor</th>
                            <th scope="col" class="px-6 py-3.5">Inspector</th>
                            <th scope="col" class="px-6 py-3.5">Report Status</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100 text-sm">
                        @foreach ($inspections as $inspection)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">
                                    {{ $inspection->property->title ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600 text-xs">
                                    {{ $inspection->property->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600 text-xs">
                                    {{ $inspection->inspector->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $status = strtolower($inspection->status);
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold 
                                        {{ in_array($status, ['approved', 'completed', 'verified']) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 
                                           (in_array($status, ['rejected', 'failed']) ? 'bg-rose-50 text-rose-700 border border-rose-200/60' : 'bg-sky-50 text-sky-700 border border-sky-200/60') }}">
                                        <span class="w-1.5 h-1.5 mr-1.5 {{ in_array($status, ['approved', 'completed', 'verified']) ? 'bg-emerald-500' : (in_array($status, ['rejected', 'failed']) ? 'bg-rose-500' : 'bg-sky-500') }} rounded-full"></span> 
                                        {{ ucfirst($inspection->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('admin.verifications.show', $inspection) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-medium text-xs rounded-md transition shadow-sm">
                                        Review Report & Decide
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
            $('#verificationsTable').DataTable({
                "responsive": true,
                "pageLength": 10,
                "language": {
                    "search": "Search verifications:",
                    "lengthMenu": "Show _MENU_ entries"
                }
            });
        });
    </script>
</x-admin-layout>