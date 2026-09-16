<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-100 leading-tight">
                {{ __('Property Details') }}
            </h2>
            <a href="{{ route('vendor.properties.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-100 hover:bg-slate-50 text-xs font-semibold rounded-lg transition inline-flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Properties
            </a>
        </div>
    </x-slot>

    <!-- Archived Alert -->
    @if($property->archived_at)
        <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl mb-6 text-sm flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span><strong>Note:</strong> This property is archived and may not be visible to renters.</span>
            </div>
        </div>
    @endif

    <div class="space-y-6">
        <!-- Main Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Top Header Banner -->
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center space-x-3 mb-1">
                        <h3 class="text-xl font-bold text-slate-800">{{ $property->title }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full 
                            {{ $property->verification_status === 'Verified' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 
                               ($property->verification_status === 'Rejected' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 
                               ($property->verification_status === 'Under Review' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-amber-50 text-amber-700 border border-amber-200')) }}">
                            {{ $property->verification_status ?? 'Pending' }}
                        </span>
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
</x-admin-layout>