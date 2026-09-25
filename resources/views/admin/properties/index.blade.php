<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-100 leading-tight">
            {{ __('My Properties') }}
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
        #propertiesTable tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }
    </style>

    <!-- Session Alerts -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-4 text-sm font-medium flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl mb-4 text-sm font-medium flex items-center justify-between">
            <span>{{ session('info') }}</span>
        </div>
    @endif

    <!-- Full width container -->
    <div class="w-full">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-base font-semibold text-slate-800">Property Listings</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Manage and track your property listings and status</p>
                </div>
                <div>
                    <a href="{{ route('admin.properties.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition inline-block">
                        + Add Property
                    </a>
                </div>
            </div>

            <div class="p-6">
                <table id="propertiesTable" class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="py-3.5 px-4">Image</th>
                            <th class="py-3.5 px-4">Property</th>
                            <th class="py-3.5 px-4">Vendor</th>
                            <th class="py-3.5 px-4">Location</th>
                            <th class="py-3.5 px-4">Price</th>
                            <th class="py-3.5 px-4">Specs</th>
                            <th class="py-3.5 px-4">Type & Purpose</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm bg-white">
                        @forelse($properties as $property)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-4">
                                    <div class="w-14 h-14 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0">
                                        @if($property->main_image)
                                            <img src="{{ asset($property->main_image) }}" alt="" class="w-full h-full object-cover" />
                                        @elseif($property->images->first())
                                            <img src="{{ asset($property->images->first()->image_url) }}" alt="" class="w-full h-full object-cover" />
                                        @else
                                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                            </svg>
                                        @endif
                                    </div>
                                </td>

                                <td class="py-4 px-4 font-semibold text-slate-800">
                                    <div class="flex items-center space-x-2">
                                        <span>{{ $property->title }}</span>
                                        @if($property->archived_at)
                                            <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                                Archived
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Vendor -->
                                <td class="py-4 px-4 text-slate-600 text-xs">
                                    {{ $property->user->name ?? 'N/A' }}
                                </td>

                                <!-- Location -->
                                <td class="py-4 px-4 text-slate-600 text-xs">
                                    {{ $property->address }}, {{ $property->city }}, {{ $property->state }}
                                </td>

                                <!-- Price -->
                                <td class="py-4 px-4 font-bold text-slate-900">
                                    ${{ number_format($property->price) }}
                                </td>

                                <!-- Specs -->
                                <td class="py-4 px-4 text-slate-500 text-xs">
                                    {{ $property->bedrooms ?? 0 }} Bed • {{ $property->bathrooms ?? 0 }} Bath • {{ $property->area ?? 0 }} sqft
                                </td>

                                <!-- Type & Purpose -->
                                <td class="py-4 px-4">
                                    <div class="flex items-center space-x-1.5">
                                        <span class="px-2 py-1 text-[11px] font-medium rounded-md bg-slate-100 text-slate-700">
                                            {{ ucfirst($property->type) }}
                                        </span>
                                        <span class="px-2 py-1 text-[11px] font-medium rounded-md {{ $property->purpose === 'rent' ? 'bg-purple-50 text-purple-700 border border-purple-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                                            For {{ ucfirst($property->purpose) }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Verification Status -->
                                <td class="py-4 px-4">
                                    @php
                                        $status = $property->verification_status ?? 'Pending';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full 
                                        {{ $status === 'Verified' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 
                                           ($status === 'Rejected' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 
                                           ($status === 'Under Review' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-amber-50 text-amber-700 border border-amber-200')) }}">
                                        {{ $status }}
                                        @if($property->is_verified)
                                            <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-4 text-right space-x-1.5 whitespace-nowrap">
                                    <a href="{{ route('admin.properties.edit', $property) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-medium text-xs rounded-md transition shadow-sm">
                                        Edit
                                    </a>

                                    <a href="{{ route('admin.properties.show', $property) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 font-medium text-xs rounded-md transition shadow-sm">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <!-- Empty State handled gracefully if needed -->
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
            $('#propertiesTable').DataTable({
                "responsive": true,
                "pageLength": 10,
                "language": {
                    "search": "Search properties:",
                    "lengthMenu": "Show _MENU_ entries"
                }
            });
        });
    </script>
</x-admin-layout>