<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Payouts') }}
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
        #payoutsTable tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }
    </style>

    <!-- Alpine.js data container for Modal & Full Width Wrapper -->
    <div class="w-full" x-data="{ openPayModal: false, payoutId: null, amount: '' }">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            
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

            <div class="p-6">
                <table id="payoutsTable" class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th scope="col" class="px-6 py-3.5">ID</th>
                            <th scope="col" class="px-6 py-3.5">Vendor</th>
                            <th scope="col" class="px-6 py-3.5">Property</th>
                            <th scope="col" class="px-6 py-3.5">Amount</th>
                            <th scope="col" class="px-6 py-3.5">Status</th>
                            <th scope="col" class="px-6 py-3.5">Payout Date</th>
                            <th scope="col" class="px-6 py-3.5">Transaction ID</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100 text-sm">
                        @forelse ($payouts as $payout)
                            @php
                                $booking = $payout->booking;
                                $vendor = $booking?->vendor;
                                $property = $booking?->property;
                                $status = strtolower($payout->status);
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-500">#{{ $payout->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600 text-xs">{{ $vendor->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">{{ $property->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-900">${{ number_format($payout->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold 
                                        {{ in_array($status, ['approved', 'completed']) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 
                                           (in_array($status, ['rejected']) ? 'bg-rose-50 text-rose-700 border border-rose-200/60' : 'bg-amber-50 text-amber-700 border border-amber-200/60') }}">
                                        <span class="w-1.5 h-1.5 mr-1.5 {{ in_array($status, ['approved', 'completed']) ? 'bg-emerald-500' : (in_array($status, ['rejected']) ? 'bg-rose-500' : 'bg-amber-500') }} rounded-full"></span>
                                        {{ ucfirst($payout->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-500 text-xs">
                                    {{ $payout->payout_date ? \Carbon\Carbon::parse($payout->payout_date)->format('M d, Y') : 'Pending' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-500 text-xs">
                                    {{ $payout->transaction_id ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    @if($payout->status == 'pending')
                                        <button @click="openPayModal = true; payoutId = '{{ $payout->id }}'; amount = '{{ $payout->amount }}'" 
                                                class="inline-flex items-center px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-medium text-xs rounded-md transition shadow-sm">
                                            Pay
                                        </button>
                                    @else
                                        <span class="text-xs text-slate-400 font-medium">Completed</span>
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

        <!-- PAYOUT POPUP MODAL -->
        <div x-show="openPayModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
            <div @click.away="openPayModal = false" class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6 relative border border-slate-100">
                
                <!-- Close Button -->
                <button @click="openPayModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                
                <h3 class="text-lg font-semibold text-slate-800 mb-4 border-b border-slate-100 pb-3">Process Payout (<span class="text-indigo-600" x-text="'$' + amount"></span>)</h3>

                <!-- Form -->
                <form :action="'{{ route('admin.payouts.index') }}/' + payoutId" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4 text-sm text-slate-600">
                        <!-- Transaction ID -->
                        <div>
                            <label class="block font-semibold text-slate-700 text-xs mb-1 uppercase tracking-wider">Transaction ID</label>
                            <input type="text" name="transaction_id" required placeholder="e.g. TXN-98234759" class="w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Payout Date -->
                        <div>
                            <label class="block font-semibold text-slate-700 text-xs mb-1 uppercase tracking-wider">Payout Date</label>
                            <input type="date" name="payout_date" required class="w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ date('Y-m-d') }}">
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block font-semibold text-slate-700 text-xs mb-1 uppercase tracking-wider">Notes (Optional)</label>
                            <textarea name="notes" rows="3" placeholder="Add any comments or payment remarks..." class="w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                    </div>

                    <!-- Modal Footer Buttons -->
                    <div class="mt-6 flex justify-end space-x-2">
                        <button type="button" @click="openPayModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-lg text-xs font-semibold transition">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 rounded-lg text-xs font-semibold shadow-sm transition">Confirm Payment</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- jQuery & DataTables JS CDNs -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#payoutsTable').DataTable({
                "responsive": true,
                "pageLength": 10,
                "language": {
                    "search": "Search payouts:",
                    "lengthMenu": "Show _MENU_ entries"
                }
            });
        });
    </script>
</x-admin-layout>