<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Inquries Management') }}
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
        #inquiriesTable tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }
    </style>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-4 text-sm font-medium flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Full width container -->
    <div class="w-full">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-base font-semibold text-slate-800">Customer Inquries</h3>
                    <p class="text-xs text-slate-500 mt-0.5">View and manage form submissions from contact page</p>
                </div>
            </div>

            <div class="p-6">
                <table id="inquiriesTable" class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th scope="col" class="px-6 py-3.5">ID</th>
                            <th scope="col" class="px-6 py-3.5">Name & Email</th>
                            <th scope="col" class="px-6 py-3.5">Phone</th>
                            <th scope="col" class="px-6 py-3.5">Subject</th>
                            <th scope="col" class="px-6 py-3.5">Message</th>
                            <th scope="col" class="px-6 py-3.5">Date</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100 text-sm">
                        @forelse($inquries as $inquiry)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-slate-500 text-xs">#{{ $inquiry->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800">{{ $inquiry->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $inquiry->email }}</div>
                                </td>
                                <td class="px-6 py-4 text-slate-600 text-xs whitespace-nowrap">{{ $inquiry->phone }}</td>
                                <td class="px-6 py-4 font-medium text-slate-700 max-w-xs truncate">{{ $inquiry->subject }}</td>
                                <td class="px-6 py-4 text-slate-600 text-xs max-w-xs truncate">
                                    {{ $inquiry->message ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                                    {{ $inquiry->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <form action="{{ route('admin.inquries.destroy', $inquiry->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 font-medium text-xs rounded-md transition shadow-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <!-- Empty state handled by DataTables -->
                        @endforelse
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
            $('#inquiriesTable').DataTable({
                "responsive": true,
                "pageLength": 10,
                "language": {
                    "search": "Search inquiries:",
                    "lengthMenu": "Show _MENU_ entries"
                }
            });
        });
    </script>
</x-admin-layout>