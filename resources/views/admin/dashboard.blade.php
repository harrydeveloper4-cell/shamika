<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-gray-500 text-sm">Total Users</div>
                        <div class="text-3xl font-bold mt-2">{{ \App\Models\User::count() }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-gray-500 text-sm">Total Properties</div>
                        <div class="text-3xl font-bold mt-2">{{ \App\Models\Property::count() }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-gray-500 text-sm">Pending Monitoring Requests</div>
                        <div class="text-3xl font-bold mt-2">{{ \App\Models\MonitoringRequest::where('status', 'Pending')->count() }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-gray-500 text-sm">Verifications Pending Decision</div>
                        <div class="text-3xl font-bold mt-2">{{ \App\Models\Inspection::where('status', 'Report Submitted')->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Recent Monitoring Requests</h3>
                            <a href="{{ route('admin.monitoring-requests.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                        <div class="space-y-3">
                            @foreach(\App\Models\MonitoringRequest::with(['property', 'vendor'])->latest()->take(5)->get() as $request)
                                <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                                    <div>
                                        <div class="font-medium">{{ $request->property->title ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">{{ $request->vendor->name ?? 'Unknown' }} - {{ $request->created_at->diffForHumans() }}</div>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $request->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' :
                                           ($request->status === 'reviewed' ? 'bg-blue-100 text-blue-800' :
                                           ($request->status === 'assigned' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Inspections Awaiting Decision</h3>
                            <a href="{{ route('admin.verifications.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                        <div class="space-y-3">
                            @foreach(\App\Models\Inspection::with(['property.user', 'inspector'])->where('status', 'Report Submitted')->latest()->take(5)->get() as $inspection)
                                <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                                    <div>
                                        <div class="font-medium">{{ $inspection->property->title ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">Inspector: {{ $inspection->inspector->name ?? 'Unknown' }}</div>
                                        <div class="text-sm text-gray-500">Recommendation:
                                            <span class="{{ $inspection->recommendation === 'approve' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ ucfirst($inspection->recommendation) }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.verifications.show', $inspection) }}" class="text-sm text-blue-600 hover:text-blue-800">Review</a>
                                </div>
                            @endforeach
                            @if(\App\Models\Inspection::where('status', 'Report Submitted')->count() === 0)
                                <div class="text-gray-500 text-sm py-4 text-center">No inspections awaiting decision.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
