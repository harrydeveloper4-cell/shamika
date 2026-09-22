<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-100 leading-tight">
                {{ __('Property Details') }}
            </h2>
            <a href="{{ route('vendor.properties.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold rounded-lg transition inline-flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Properties
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Main Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Top Header Banner -->
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center space-x-3 mb-1">
                        <h3 class="text-xl font-bold text-slate-800">{{ $property->title }}</h3>
                        @if($property->inspections()->count() > 0)
                        <span class="px-2 py-0.5 text-xs rounded
                            {{ $property->inspections[0]->recommendation === 'approve' ? 'bg-green-100 text-green-700' :
                                ($property->inspections[0]->recommendation === 'rejecte' ? 'bg-red-100 text-red-700' :
                                ($property->inspections[0]->recommendation === 'pending' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700')) }}">
                            {{ ucfirst($property->inspections[0]->recommendation) }}
                            @if($property->inspections[0]->recommendation === 'approve') ✓ @endif
                        </span>
                        @else
                        <span class="px-2 py-0.5 text-xs rounded bg-yellow-100 text-yellow-700">
                            {{ $property->monitoringRequests()->count() > 0 ? ucfirst($property->monitoringRequests[0]->status) : 'Required to verification' }}
                        </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $property->address }}, {{ $property->city }}, {{ $property->state }} {{ $property->zip_code }}, {{ $property->country }}
                    </p>
                </div>

                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-black text-indigo-600">${{ number_format($property->price, 2) }}</span>
                    <a href="{{ route('vendor.properties.edit', $property) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                        Edit Property
                    </a>
                </div>
            </div>

            <!-- Property Overview Grid -->
            <div class="p-6 grid grid-cols-2 sm:grid-cols-4 gap-4 bg-slate-50/30 border-b border-slate-100">
                <div class="p-3.5 bg-white rounded-lg border border-slate-100 shadow-2xs">
                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Type</span>
                    <span class="text-sm font-semibold text-slate-700 capitalize mt-0.5 block">{{ $property->type }}</span>
                </div>
                <div class="p-3.5 bg-white rounded-lg border border-slate-100 shadow-2xs">
                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Purpose</span>
                    <span class="text-sm font-semibold text-slate-700 capitalize mt-0.5 block">For {{ $property->purpose }}</span>
                </div>
                <div class="p-3.5 bg-white rounded-lg border border-slate-100 shadow-2xs">
                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bedrooms</span>
                    <span class="text-sm font-semibold text-slate-700 mt-0.5 block">{{ $property->bedrooms ?? 0 }} Beds</span>
                </div>
                <div class="p-3.5 bg-white rounded-lg border border-slate-100 shadow-2xs">
                    <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Area</span>
                    <span class="text-sm font-semibold text-slate-700 mt-0.5 block">{{ $property->area ?? 0 }} sqft</span>
                </div>
            </div>

            <!-- Detailed Specifications -->
            <div class="p-6 space-y-6">
                <!-- Description Section -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Description</h4>
                    <div class="p-4 bg-slate-50/70 rounded-xl border border-slate-100 text-sm text-slate-600 leading-relaxed">
                        {{ $property->description ?? 'No description provided for this property.' }}
                    </div>
                </div>

                <!-- Attributes Table/Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                    <!-- Property Features -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Key Features</h4>
                        <dl class="divide-y divide-slate-100 text-sm">
                            <div class="py-2.5 flex justify-between">
                                <dt class="text-slate-500">Bathrooms</dt>
                                <dd class="font-semibold text-slate-800">{{ $property->bathrooms ?? 0 }}</dd>
                            </div>
                            <div class="py-2.5 flex justify-between">
                                <dt class="text-slate-500">Is Verified</dt>
                                <dd class="font-semibold text-slate-800">{{ $property->is_verified ? 'Yes' : 'No' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Address Details -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Address Breakdown</h4>
                        <dl class="divide-y divide-slate-100 text-sm">
                            <div class="py-2.5 flex justify-between">
                                <dt class="text-slate-500">Street</dt>
                                <dd class="font-semibold text-slate-800">{{ $property->address }}</dd>
                            </div>
                            <div class="py-2.5 flex justify-between">
                                <dt class="text-slate-500">City / State</dt>
                                <dd class="font-semibold text-slate-800">{{ $property->city }}, {{ $property->state }}</dd>
                            </div>
                            <div class="py-2.5 flex justify-between">
                                <dt class="text-slate-500">Postal / Country</dt>
                                <dd class="font-semibold text-slate-800">{{ $property->zip_code }}, {{ $property->country }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
