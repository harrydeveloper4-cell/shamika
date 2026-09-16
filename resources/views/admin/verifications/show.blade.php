<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Verification Decision') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Inspection Report for {{ $inspection->property->title }}</h3>

                    <div class="mb-4">
                        <p><strong>Property:</strong> {{ $inspection->property->title }}</p>
                        <p><strong>Vendor:</strong> {{ $inspection->property->user->name }}</p>
                        <p><strong>Inspector:</strong> {{ $inspection->inspector->name }}</p>
                        <p><strong>Inspection Status:</strong> {{ $inspection->inspection_status }}</p>
                        <p><strong>Scheduled At:</strong> {{ $inspection->scheduled_at?->format('M d, Y H:i A') ?? 'N/A' }}</p>
                        <p><strong>Completed At:</strong> {{ $inspection->completed_at?->format('M d, Y H:i A') ?? 'N/A' }}</p>
                        <p><strong>Inspector Notes:</strong> {{ $inspection->notes ?? 'N/A' }}</p>
                        <p><strong>Inspector Recommendation:</strong> {{ ucfirst($inspection->recommendation) }}</p>
                        <p><strong>Report Submitted At:</strong> {{ $inspection->report_submitted_at?->format('M d, Y H:i A') ?? 'N/A' }}</p>

                        @if ($inspection->checklist)
                            <h4 class="font-semibold text-lg mt-4">Checklist:</h4>
                            <ul>
                                @foreach ($inspection->checklist as $item => $value)
                                    <li>{{ ucfirst(str_replace('_', ' ', $item)) }}: {{ $value ? 'Yes' : 'No' }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if ($inspection->photos_documents)
                            <h4 class="font-semibold text-lg mt-4">Photos & Documents:</h4>
                            <ul>
                                @foreach ($inspection->photos_documents as $doc)
                                    <li><a href="{{ Storage::url($doc) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">{{ basename($doc) }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <hr class="my-6">

                    <h4 class="text-lg font-medium text-gray-900 mb-4">Make Verification Decision</h4>
                    <form method="POST" action="{{ route('admin.verifications.decide', $inspection->property) }}">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="inspection_id" value="{{ $inspection->id }}">

                        <div class="mb-4">
                            <x-input-label for="decision" :value="__('Verification Decision')" />
                            <select name="decision" id="decision" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">-- Select Decision --</option>
                                <option value="Verified">Verified</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('decision')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="reason" :value="__('Reason (for rejection, optional)')" />
                            <x-textarea id="reason" name="reason" class="block mt-1 w-full" rows="3">{{ old('reason') }}</x-textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('reason')" />
                        </div>

                        <x-primary-button>
                            {{ __('Submit Decision') }}
                        </x-primary-button>
                    </form>

                    @if (session('success'))
                        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>