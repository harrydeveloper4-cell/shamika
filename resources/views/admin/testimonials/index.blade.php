<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Testimonials') }}
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
        #testimonialsTable tbody tr {
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
                    <h3 class="text-base font-semibold text-slate-800">Testimonials List</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Manage customer reviews and feedback</p>
                </div>
                <div>
                    <a href="{{ route('admin.testimonials.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition inline-block">
                        + Add Testimonial
                    </a>
                </div>
            </div>

            <div class="p-6">
                <table id="testimonialsTable" class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th scope="col" class="px-6 py-3.5">User</th>
                            <th scope="col" class="px-6 py-3.5">Rating</th>
                            <th scope="col" class="px-6 py-3.5">Message</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100 text-sm">
                        @forelse($testimonials as $testimonial)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-slate-800">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ asset($testimonial->image) }}" class="w-9 h-9 rounded-full object-cover border border-slate-200" alt="{{ $testimonial->name }}">
                                        <span>{{ $testimonial->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                        ★ {{ $testimonial->rating }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600 text-xs max-w-xs truncate">{{ $testimonial->message }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-1.5">
                                    <a href="{{ route('admin.testimonials.show', $testimonial->id) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-50 text-slate-700 hover:bg-slate-100 font-medium text-xs rounded-md transition shadow-sm border border-slate-200">View</a>
                                    <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-medium text-xs rounded-md transition shadow-sm">Edit</a>
                                    <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
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
            $('#testimonialsTable').DataTable({
                "responsive": true,
                "pageLength": 10,
                "language": {
                    "search": "Search testimonials:",
                    "lengthMenu": "Show _MENU_ entries"
                }
            });
        });
    </script>
</x-admin-layout>