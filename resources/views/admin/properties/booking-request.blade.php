<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Booking Requests') }}
        </h2>
    </x-slot>

    <!-- Alpine.js data container -->
    <div class="py-12" x-data="{ openModal: false, selectedBooking: {} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Booking Properties Requests</h3>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Renter</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($bookings as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->property->title ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->renter->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <!-- View Details Button -->
                                        <button @click="selectedBooking = {{ json_encode($booking) }}; openModal = true" class="text-indigo-600 hover:text-indigo-900 focus:outline-none">
                                            View Details
                                        </button>
                                        @if($booking->status == 'pending')
                                        <a href="{{ route('booking-request.accept-to-pay', $booking->id) }}" class="text-green-600 hover:text-red-900 focus:outline-none">
                                            Accept Request to pay 
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No booking requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- POPUP MODAL -->
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center p-4" style="display: none;">
            <div @click.away="openModal = false" class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6 relative">
                
                <!-- Close Button -->
                <button @click="openModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                
                <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Booking Request Details</h3>

                <div class="space-y-4 text-sm text-gray-700">
                    <!-- Booking Info -->
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="font-semibold text-gray-900 mb-1">Booking Info:</p>
                        <p><strong>Booking ID:</strong> #<span x-text="selectedBooking.id"></span></p>
                        <p><strong>Booking Date:</strong> <span x-text="selectedBooking.booking_date"></span></p>
                        <p><strong>Status:</strong> <span class="capitalize font-semibold text-yellow-600" x-text="selectedBooking.status"></span></p>
                        <p><strong>Notes:</strong> <span x-text="selectedBooking.notes ?? 'N/A'"></span></p>
                    </div>

                    <!-- Property Info -->
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="font-semibold text-gray-900 mb-1">Property Details:</p>
                        <p><strong>Title:</strong> <span x-text="selectedBooking.property ? selectedBooking.property.title : 'N/A'"></span></p>
                        <p><strong>Address:</strong> <span x-text="selectedBooking.property ? selectedBooking.property.address + ', ' + selectedBooking.property.city : 'N/A'"></span></p>
                        <p><strong>Price:</strong> $<span x-text="selectedBooking.property ? selectedBooking.property.price : 'N/A'"></span></p>
                    </div>

                    <!-- Renter Info -->
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="font-semibold text-gray-900 mb-1">Renter / User Details:</p>
                        <p><strong>Name:</strong> <span x-text="selectedBooking.renter ? selectedBooking.renter.name : 'N/A'"></span></p>
                        <p><strong>Email:</strong> <span x-text="selectedBooking.renter ? selectedBooking.renter.email : 'N/A'"></span></p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="mt-6 flex justify-end">
                    <button @click="openModal = false" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm">Close</button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>