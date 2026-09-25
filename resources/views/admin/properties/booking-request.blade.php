<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Booking Requests') }}
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
        #bookingsTable tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }
    </style>

    <!-- Alpine.js data container -->
    <div class="w-full" x-data="{ openModal: false, selectedBooking: {} }">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-base font-semibold text-slate-800">Booking Properties Requests</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Manage and review incoming property booking requests from renters</p>
                </div>
            </div>

            <div class="p-6">
                <table id="bookingsTable" class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th scope="col" class="px-6 py-3.5">Property</th>
                            <th scope="col" class="px-6 py-3.5">Renter</th>
                            <th scope="col" class="px-6 py-3.5">Booking Date</th>
                            <th scope="col" class="px-6 py-3.5">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100 text-sm">
                        @forelse ($bookings as $booking)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">
                                    {{ $booking->property->title ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600 text-xs">
                                    {{ $booking->renter->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600 text-xs">
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $status = strtolower($booking->status);
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold 
                                        {{ in_array($status, ['approved', 'accepted', 'completed']) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 
                                           (in_array($status, ['rejected', 'cancelled']) ? 'bg-rose-50 text-rose-700 border border-rose-200/60' : 'bg-amber-50 text-amber-700 border border-amber-200/60') }}">
                                        <span class="w-1.5 h-1.5 mr-1.5 {{ in_array($status, ['approved', 'accepted', 'completed']) ? 'bg-emerald-500' : (in_array($status, ['rejected', 'cancelled']) ? 'bg-rose-500' : 'bg-amber-500') }} rounded-full"></span> 
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-1.5">
                                    <!-- View Details Button -->
                                    <button @click="selectedBooking = {{ json_encode($booking) }}; openModal = true" class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 font-medium text-xs rounded-md transition shadow-sm">
                                        View Details
                                    </button>
                                    @if($booking->status == 'pending')
                                        <a href="{{ route('booking-request.accept-to-pay', $booking->id) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-medium text-xs rounded-md transition shadow-sm">
                                            Accept to Pay
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <!-- Empty state handled by DataTables / table structure -->
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- POPUP MODAL -->
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
            <div @click.away="openModal = false" class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6 relative border border-slate-100">
                
                <!-- Close Button -->
                <button @click="openModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                
                <h3 class="text-lg font-semibold text-slate-800 mb-4 border-b border-slate-100 pb-3">Booking Request Details</h3>

                <div class="space-y-4 text-sm text-slate-600">
                    <!-- Booking Info -->
                    <div class="bg-slate-50 p-3.5 rounded-lg border border-slate-100">
                        <p class="font-semibold text-slate-800 mb-2 text-xs uppercase tracking-wider">Booking Info</p>
                        <div class="space-y-1.5 text-xs">
                            <p><strong>Booking ID:</strong> #<span x-text="selectedBooking.id"></span></p>
                            <p><strong>Booking Date:</strong> <span x-text="selectedBooking.booking_date"></span></p>
                            <p><strong>Status:</strong> <span class="capitalize font-semibold text-amber-600" x-text="selectedBooking.status"></span></p>
                            <p><strong>Notes:</strong> <span x-text="selectedBooking.notes ?? 'N/A'"></span></p>
                        </div>
                    </div>

                    <!-- Property Info -->
                    <div class="bg-slate-50 p-3.5 rounded-lg border border-slate-100">
                        <p class="font-semibold text-slate-800 mb-2 text-xs uppercase tracking-wider">Property Details</p>
                        <div class="space-y-1.5 text-xs">
                            <p><strong>Title:</strong> <span x-text="selectedBooking.property ? selectedBooking.property.title : 'N/A'"></span></p>
                            <p><strong>Address:</strong> <span x-text="selectedBooking.property ? selectedBooking.property.address + ', ' + selectedBooking.property.city : 'N/A'"></span></p>
                            <p><strong>Price:</strong> $<span x-text="selectedBooking.property ? selectedBooking.property.price : 'N/A'"></span></p>
                        </div>
                    </div>

                    <!-- Renter Info -->
                    <div class="bg-slate-50 p-3.5 rounded-lg border border-slate-100">
                        <p class="font-semibold text-slate-800 mb-2 text-xs uppercase tracking-wider">Renter / User Details</p>
                        <div class="space-y-1.5 text-xs">
                            <p><strong>Name:</strong> <span x-text="selectedBooking.renter ? selectedBooking.renter.name : 'N/A'"></span></p>
                            <p><strong>Email:</strong> <span x-text="selectedBooking.renter ? selectedBooking.renter.email : 'N/A'"></span></p>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="mt-6 flex justify-end">
                    <button @click="openModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-lg text-xs font-semibold transition">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery & DataTables JS CDNs -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#bookingsTable').DataTable({
                "responsive": true,
                "pageLength": 10,
                "language": {
                    "search": "Search bookings:",
                    "lengthMenu": "Show _MENU_ entries"
                }
            });
        });
    </script>
</x-admin-layout>