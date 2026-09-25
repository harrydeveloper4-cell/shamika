<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Booking Requests') }}
        </h2>
    </x-slot>

    <!-- Alpine.js data container -->
    <div x-data="{ openModal: false, selectedBooking: {} }" class="w-full">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
            <div class="p-6 text-slate-800">
                <h3 class="text-base font-semibold text-slate-800 mb-4">Booking Properties Requests</h3>

                <div class="overflow-x-auto">
                    <table id="bookingTable" class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Property</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Renter</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Booking Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse ($bookings as $booking)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-800">{{ $booking->property->title ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $booking->renter->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-100">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right space-x-2">
                                        <!-- View Details Button -->
                                        <button @click="selectedBooking = {{ json_encode($booking) }}; openModal = true" class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs focus:outline-none">
                                            View Details
                                        </button>
                                        
                                        @if($booking->status == 'confirmed')
                                            <span class="text-slate-300">|</span>
                                            <a href="{{ route('renter.booking-request.paynow', encrypt($booking->id)) }}" class="text-emerald-600 hover:text-emerald-900 font-semibold text-xs focus:outline-none">
                                                Pay Now 
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500 text-sm">No booking requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- POPUP MODAL -->
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
            <div @click.away="openModal = false" class="bg-white rounded-xl shadow-xl max-w-2xl w-full p-6 relative border border-slate-200">
                
                <!-- Close Button -->
                <button @click="openModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                
                <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Booking Request Details</h3>

                <div class="space-y-4 text-sm text-slate-600">
                    <!-- Booking Info -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 shadow-sm">
                        <p class="font-semibold text-slate-800 mb-2">Booking Info:</p>
                        <p class="mb-1"><strong>Booking ID:</strong> #<span x-text="selectedBooking.id"></span></p>
                        <p class="mb-1"><strong>Booking Date:</strong> <span x-text="selectedBooking.booking_date"></span></p>
                        <p class="mb-1"><strong>Status:</strong> <span class="capitalize font-semibold text-amber-600" x-text="selectedBooking.status"></span></p>
                        <p><strong>Notes:</strong> <span x-text="selectedBooking.notes ?? 'N/A'"></span></p>
                    </div>

                    <!-- Property Info -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 shadow-sm">
                        <p class="font-semibold text-slate-800 mb-2">Property Details:</p>
                        <p class="mb-1"><strong>Title:</strong> <span x-text="selectedBooking.property ? selectedBooking.property.title : 'N/A'"></span></p>
                        <p class="mb-1"><strong>Address:</strong> <span x-text="selectedBooking.property ? selectedBooking.property.address + ', ' + selectedBooking.property.city : 'N/A'"></span></p>
                        <p><strong>Price:</strong> $<span x-text="selectedBooking.property ? selectedBooking.property.price : 'N/A'"></span></p>
                    </div>

                    <!-- Renter Info -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 shadow-sm">
                        <p class="font-semibold text-slate-800 mb-2">Renter / User Details:</p>
                        <p class="mb-1"><strong>Name:</strong> <span x-text="selectedBooking.renter ? selectedBooking.renter.name : 'N/A'"></span></p>
                        <p><strong>Email:</strong> <span x-text="selectedBooking.renter ? selectedBooking.renter.email : 'N/A'"></span></p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="mt-6 flex justify-end">
                    <button @click="openModal = false" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-xs font-semibold transition">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables JS & Initialization -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof jQuery !== 'undefined') {
                $(document).ready(function() {
                    $('#bookingTable').DataTable({
                        responsive: true,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Search bookings..."
                        }
                    });
                });
            }
        });
    </script>
</x-app-layout>