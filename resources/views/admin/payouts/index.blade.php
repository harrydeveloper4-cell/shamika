<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Payouts') }}
        </h2>
    </x-slot>

    <!-- Alpine.js data container for Modal -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden" 
         x-data="{ openPayModal: false, payoutId: null, amount: '' }">
        
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h3 class="text-base font-semibold text-slate-800">Payout Records</h3>
                <p class="text-xs text-slate-500 mt-0.5">Manage and track vendor payout histories</p>
            </div>
            <div>
                <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                    + Process New Payout
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-6">ID</th>
                        <th class="py-3.5 px-6">Vendor</th>
                        <th class="py-3.5 px-6">Property</th>
                        <th class="py-3.5 px-6">Amount</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6">Payout Date</th>
                        <th class="py-3.5 px-6">Transaction ID</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($payouts as $payout)
                        @php
                            $booking = $payout->booking;
                            $vendor = $booking?->vendor;
                            $property = $booking?->property;
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-medium text-slate-800">#{{ $payout->id }}</td>
                            
                            <!-- Vendor Name -->
                            <td class="py-4 px-6 text-slate-600">{{ $vendor->name ?? 'N/A' }}</td>

                            <!-- Property Title -->
                            <td class="py-4 px-6 text-slate-600">{{ $property->title ?? 'N/A' }}</td>

                            <!-- Amount -->
                            <td class="py-4 px-6 font-bold text-slate-900">${{ number_format($payout->amount, 2) }}</td>

                            <!-- Status Badge -->
                            <td class="py-4 px-6">
                                @php
                                    $statusClasses = match($payout->status) {
                                        'approved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        default => 'bg-yellow-100 text-yellow-800',
                                    };
                                @endphp
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusClasses }}">
                                    {{ ucfirst($payout->status) }}
                                </span>
                            </td>

                            <!-- Payout Date -->
                            <td class="py-4 px-6 text-slate-500 text-xs">
                                {{ $payout->payout_date ? $payout->payout_date->format('M d, Y') : 'Pending' }}
                            </td>

                            <!-- Transaction ID -->
                            <td class="py-4 px-6 text-slate-500 text-xs">
                                {{ $payout->transaction_id ?? 'N/A' }}
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right space-x-2">
                                @if($payout->status == 'pending')
                                    <!-- Pay Button -->
                                    <button @click="openPayModal = true; payoutId = '{{ $payout->id }}'; amount = '{{ $payout->amount }}'" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md text-xs font-semibold shadow-sm transition">
                                        Pay
                                    </button>
                                @else
                                    <span class="text-xs text-slate-400 font-medium">Completed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        {{-- Empty State --}}
                        <tr>
                            <td colspan="8" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-slate-600 font-semibold text-base">No payouts found</p>
                                    <p class="text-slate-400 text-xs mt-1">There are currently no payout records available in the system.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAYOUT POPUP MODAL -->
        <div x-show="openPayModal" class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center p-4" style="display: none;">
            <div @click.away="openPayModal = false" class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6 relative">
                
                <!-- Close Button -->
                <button @click="openPayModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                
                <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Process Payout (<span class="text-indigo-600" x-text="'$' + amount"></span>)</h3>

                <!-- Form -->
                <form :action="'{{ route('admin.payouts.index') }}/' + payoutId" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4 text-sm">
                        <!-- Transaction ID -->
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Transaction ID</label>
                            <input type="text" name="transaction_id" required placeholder="e.g. TXN-98234759" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Payout Date -->
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Payout Date</label>
                            <input type="date" name="payout_date" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ date('Y-m-d') }}">
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Notes (Optional)</label>
                            <textarea name="notes" rows="3" placeholder="Add any comments or payment remarks..." class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                    </div>

                    <!-- Modal Footer Buttons -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" @click="openPayModal = false" class="bg-gray-200 text-slate-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-xs font-semibold">Cancel</button>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-xs font-semibold shadow-sm">Confirm Payment</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</x-admin-layout>