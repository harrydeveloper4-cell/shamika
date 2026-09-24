<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Commissions & Payouts') }}
        </h2>
    </x-slot>

    @php
    $commissionSetting = App\Models\CommissionSetting::latest()->first();
    @endphp

    <!-- Alpine.js data container for View Detail Modal -->
    <div class="py-12" x-data="{ openDetailModal: false, selectedBooking: {} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Your Confirmed Bookings & Earnings</h3>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commission ({{ $commissionSetting->value ?? 0 }}%)</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($bookings as $booking)
                                @php
                                    $propertyPrice = $booking->property->price ?? 0;
                                    $commission = $propertyPrice * (($commissionSetting->value ?? 0) / 100); 
                                    $total = ($propertyPrice - $commission); 
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->property->title ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($propertyPrice, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-green-600">${{ number_format($total, 2) }}</td>
                                    
                                    <!-- Status Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($booking->payout)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $booking->payout->status == 'completed' ? 'bg-green-100 text-green-800' : ($booking->payout->status == 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($booking->payout->status) }}
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Not Requested
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Action Column -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if(!$booking->payout)
                                            <!-- Request Payout Button -->
                                            <a href="{{ route('vendor.payout.request', $booking->id) }}" class="bg-indigo-600 text-white px-4 py-1.5 rounded-md text-xs font-semibold hover:bg-indigo-700 focus:outline-none transition">
                                                Request Payout
                                            </a>
                                        @else
                                            <!-- View Details Button -->
                                            <button @click="openDetailModal = true; selectedBooking = {
                                                propertyTitle: '{{ addslashes($booking->property->title ?? 'N/A') }}',
                                                propertyPrice: '{{ number_format($propertyPrice, 2) }}',
                                                netEarnings: '{{ number_format($total, 2) }}',
                                                status: '{{ ucfirst($booking->payout->status) }}',
                                                transactionId: '{{ $booking->payout->transaction_id ?? 'N/A' }}',
                                                payoutDate: '{{ $booking->payout->payout_date ? \Carbon\Carbon::parse($booking->payout->payout_date)->format('M d, Y') : 'Pending' }}',
                                                notes: '{{ addslashes($booking->payout->notes ?? 'No notes available') }}'
                                            }" class="bg-slate-700 text-white px-4 py-1.5 rounded-md text-xs font-semibold hover:bg-slate-800 focus:outline-none transition">
                                                View Details
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No confirmed bookings found for commission.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- VIEW DETAILS POPUP MODAL -->
        <div x-show="openDetailModal" class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center p-4" style="display: none;">
            <div @click.away="openDetailModal = false" class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6 relative">
                
                <!-- Close Button -->
                <button @click="openDetailModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                
                <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Payout & Booking Details</h3>

                <div class="space-y-3 text-sm text-slate-600">
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-slate-700">Property:</span>
                        <span class="text-slate-900 font-medium" x-text="selectedBooking.propertyTitle"></span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-slate-700">Property Price:</span>
                        <span class="text-slate-900" x-text="'$' + selectedBooking.propertyPrice"></span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-slate-700">Vendor Earnings (After Commission):</span>
                        <span class="font-bold text-green-600" x-text="'$' + selectedBooking.netEarnings"></span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-slate-700">Status:</span>
                        <span class="font-semibold px-2 py-0.5 rounded text-xs" x-text="selectedBooking.status" :class="selectedBooking.status === 'Completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'"></span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-slate-700">Transaction ID:</span>
                        <span class="text-slate-900 font-mono text-xs" x-text="selectedBooking.transactionId"></span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-slate-700">Payout Date:</span>
                        <span class="text-slate-900" x-text="selectedBooking.payoutDate"></span>
                    </div>
                    <div>
                        <span class="block font-semibold text-slate-700 mb-1">Notes / Remarks:</span>
                        <p class="bg-slate-50 p-3 rounded-lg text-xs text-slate-600 border border-slate-200" x-text="selectedBooking.notes"></p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="mt-6 flex justify-end">
                    <button type="button" @click="openDetailModal = false" class="bg-gray-200 text-slate-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-xs font-semibold">Close</button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>