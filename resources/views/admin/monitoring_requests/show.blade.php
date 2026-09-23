<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Review Monitoring Request') }}
        </h2>
    </x-slot>
    
    <div class="space-y-6">
        <!-- Main Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Monitoring Request Details</h3>

                    <div class="mb-4">
                        <p><strong>Property:</strong> {{ $monitoringRequest->property->title }}</p>
                        <p><strong>Requester:</strong> {{ $monitoringRequest->renter ? $monitoringRequest->renter->name . ' (Renter)' : $monitoringRequest->vendor->name . ' (Vendor)' }}</p>
                        <p><strong>Current Status:</strong> {{ ucfirst($monitoringRequest->status) }}</p>
                        <p><strong>Submitted At:</strong> {{ $monitoringRequest->submitted_at->format('M d, Y H:i A') }}</p>
                        @if ($monitoringRequest->admin)
                            <p><strong>Reviewed By:</strong> {{ $monitoringRequest->admin->name }}</p>
                            <p><strong>Reviewed At:</strong> {{ $monitoringRequest->reviewed_at->format('M d, Y H:i A') }}</p>
                            <p><strong>Admin Notes:</strong> {{ $monitoringRequest->notes }}</p>
                        @endif
                        @if ($monitoringRequest->assignedInspector)
                            <p><strong>Assigned Inspector:</strong> {{ $monitoringRequest->assignedInspector->name }}</p>
                            <p><strong>Assigned At:</strong> {{ $monitoringRequest->assigned_at->format('M d, Y H:i A') }}</p>
                        @endif
                    </div>

                    @if ($monitoringRequest->status === 'pending' || $monitoringRequest->status === 'reviewed')
                        <hr class="my-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Review Request</h4>
                        <form method="POST" action="{{ route('admin.monitoring-requests.review', $monitoringRequest) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <x-input-label for="status" :value="__('Decision')" />
                                <select name="status" id="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="" {{ $monitoringRequest->status === 'reviewed' ? 'selected' : '' }}>Mark as Reviewed</option>
                                    <option value="rejected" {{ $monitoringRequest->status === 'rejected' ? 'selected' : '' }}>Reject Request</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="notes" :value="__('Admin Notes (optional)')" />
                                <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes', $monitoringRequest->notes) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                            </div>

                            <x-primary-button>
                                {{ __('Submit Decision') }}
                            </x-primary-button>
                        </form>
                    @endif

                    @if ($monitoringRequest->status === 'reviewed' && $propertyManagementTeamMembers->count() > 0)
                        <hr class="my-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Assign Inspector</h4>
                        <form method="POST" action="{{ route('admin.monitoring-requests.assign-inspector', $monitoringRequest) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <x-input-label for="inspector_id" :value="__('Select Property Management Team Member')" />
                                <select name="inspector_id" id="inspector_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Select Inspector --</option>
                                    @foreach ($propertyManagementTeamMembers as $member)
                                        <option value="{{ $member->id }}" {{ ($monitoringRequest->assignedInspector && $monitoringRequest->assignedInspector->id === $member->id) ? 'selected' : '' }}>{{ $member->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('inspector_id')" />
                            </div>

                            <x-primary-button>
                                {{ __('Assign Inspector') }}
                            </x-primary-button>
                        </form>
                    @endif

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
</x-admin-layout>