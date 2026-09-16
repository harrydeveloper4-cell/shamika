<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between items-center">
            {{ __('Payout Details') }} #{{ $payout->id }}
            <a href="{{ route('admin.payouts.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to Payouts</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Payout Information</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">ID:</span>
                                    <span class="font-medium">#{{ $payout->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Amount:</span>
                                    <span class="font-medium text-lg">${{ number_format($payout->amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Status:</span>
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $payout->status === 'completed' ? 'bg-green-100 text-green-800' :
                                           ($payout->status === 'processing' ? 'bg-blue-100 text-blue-800' :
                                           ($payout->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                        {{ ucfirst($payout->status) }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Payout Date:</span>
                                    <span>{{ $payout->payout_date ? $payout->payout_date->toFormattedDateString() : 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Transaction ID:</span>
                                    <span>{{ $payout->transaction_id ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Created:</span>
                                    <span>{{ $payout->created_at ? $payout->created_at->toFormattedDateString() : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Vendor Information</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Name:</span>
                                    <span class="font-medium">{{ $payout->vendor->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Email:</span>
                                    <span>{{ $payout->vendor->email ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($payout->notes)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Notes</h3>
                            <p class="text-gray-700">{{ $payout->notes }}</p>
                        </div>
                    @endif

                    <div class="flex items-center justify-end mt-6 space-x-3">
                        <a href="{{ route('admin.payouts.edit', $payout) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit Payout
                        </a>
                        <form method="POST" action="{{ route('admin.payouts.destroy', $payout) }}" onsubmit="return confirm('Are you sure you want to delete this payout?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Delete Payout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
