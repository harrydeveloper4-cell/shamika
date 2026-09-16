<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight flex justify-between items-center">
            {{ __('Inspection Details') }} #{{ $inspection->id }}
            <a href="{{ route('pm-team.inspections.index') }}" class="text-sm text-slate-100 hover:text-gray-900">← Back to Inspections</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Property Information</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Title:</span>
                                    <span class="font-medium">{{ $inspection->property->title ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Address:</span>
                                    <span>{{ $inspection->property->address ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">City:</span>
                                    <span>{{ $inspection->property->city ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Price:</span>
                                    <span>${{ number_format($inspection->property->price ?? 0, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Type:</span>
                                    <span>{{ ucfirst($inspection->property->type ?? 'N/A') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Purpose:</span>
                                    <span>{{ ucfirst($inspection->property->purpose ?? 'N/A') }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Inspection Status</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Status:</span>
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $inspection->status === 'Report Submitted' ? 'bg-purple-100 text-purple-800' :
                                           ($inspection->status === 'Completed' ? 'bg-green-100 text-green-800' :
                                           ($inspection->status === 'In Progress' ? 'bg-blue-100 text-blue-800' :
                                           ($inspection->status === 'Scheduled' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'))) }}">
                                        {{ $inspection->status }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Scheduled At:</span>
                                    <span>{{ $inspection->scheduled_at ? $inspection->scheduled_at->toFormattedDateString() . ' at ' . $inspection->scheduled_at->format('h:i A') : 'Not scheduled' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Completed At:</span>
                                    <span>{{ $inspection->completed_at ? $inspection->completed_at->toFormattedDateString() : 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Report Submitted:</span>
                                    <span>{{ $inspection->report_submitted_at ? 'Yes - ' . $inspection->report_submitted_at->toFormattedDateString() : 'No' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Recommendation:</span>
                                    <span>
                                        @if($inspection->recommendation === 'approve')
                                            <span class="text-green-600 font-medium">Approve</span>
                                        @elseif($inspection->recommendation === 'reject')
                                            <span class="text-red-600 font-medium">Reject</span>
                                        @else
                                            <span class="text-gray-500">Pending</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($inspection->notes)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2 border-b pb-2">Inspection Notes</h3>
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $inspection->notes }}</p>
                        </div>
                    @endif

                    @if($inspection->checklist)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2 border-b pb-2">Inspection Checklist</h3>
                            <ul class="list-disc pl-5 space-y-1 text-gray-700">
                                @foreach($inspection->checklist as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            @if($inspection->status !== 'Report Submitted')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Manage Inspection</h3>

                        @if($inspection->status === 'Assigned')
                            <form method="POST" action="{{ route('pm-team.inspections.schedule', $inspection) }}" class="mb-6">
                                @csrf
                                @method('PUT')
                                <h4 class="font-medium mb-2">Schedule Inspection</h4>
                                <div class="flex gap-4 items-end">
                                    <div class="flex-1">
                                        <x-input-label for="scheduled_at" :value="__('Schedule Date & Time')" />
                                        <x-text-input id="scheduled_at" class="block mt-1 w-full" type="datetime-local" name="scheduled_at" :value="old('scheduled_at')" min="{{ date('Y-m-d\TH:i') }}" required />
                                        <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
                                    </div>
                                    <x-primary-button>
                                        {{ __('Schedule') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        @endif

                        @if(in_array($inspection->status, ['Scheduled', 'In Progress']))
                            <form method="POST" action="{{ route('pm-team.inspections.conduct', $inspection) }}" class="mb-6">
                                @csrf
                                @method('PUT')
                                <h4 class="font-medium mb-2">{{ $inspection->status === 'Scheduled' ? 'Start & Conduct Inspection' : 'Update Inspection Notes' }}</h4>
                                <div class="mb-4">
                                    <x-input-label for="notes" :value="__('Inspection Notes')" />
                                    <textarea id="notes" name="notes" rows="5" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('notes', $inspection->notes) }}</textarea>
                                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                                </div>
                                <x-primary-button>
                                    {{ $inspection->status === 'Scheduled' ? __('Start Inspection') : __('Update Notes') }}
                                </x-primary-button>
                            </form>
                        @endif

                        @if($inspection->status === 'In Progress')
                            <form method="POST" action="{{ route('pm-team.inspections.submit-report', $inspection) }}" onsubmit="return confirm('Are you sure you want to submit the inspection report? This action cannot be undone.');">
                                @csrf
                                @method('PUT')
                                <h4 class="font-medium mb-2">Submit Inspection Report & Recommendation</h4>
                                <div class="mb-4">
                                    <x-input-label for="recommendation" :value="__('Recommendation')" />
                                    <select id="recommendation" name="recommendation" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Select Recommendation</option>
                                        <option value="approve" {{ old('recommendation') === 'approve' ? 'selected' : '' }}>Approve Property</option>
                                        <option value="reject" {{ old('recommendation') === 'reject' ? 'selected' : '' }}>Reject Property</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('recommendation')" class="mt-2" />
                                </div>
                                <x-primary-button class="bg-green-600 hover:bg-green-700">
                                    {{ __('Submit Report') }}
                                </x-primary-button>
                            </form>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-blue-800">
                    <h3 class="font-semibold text-lg mb-2">Report Submitted</h3>
                    <p>The inspection report has been submitted and is now read-only. The admin will review your recommendation and make a final verification decision.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
