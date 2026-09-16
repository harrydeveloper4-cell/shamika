<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('My Properties') }}
        </h2>
    </x-slot>

    <!-- Session Alerts -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-4 text-sm font-medium flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl mb-4 text-sm font-medium flex items-center justify-between">
            <span>{{ session('info') }}</span>
        </div>
    @endif

    <!-- Table Container -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden ">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h3 class="text-base font-semibold text-slate-800">Property Listings</h3>
                <p class="text-xs text-slate-500 mt-0.5">Manage and track your property listings and status</p>
            </div>
            <div>
                <a href="{{ route('admin.properties.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition inline-block">
                    + Add Property
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-6">Property</th>
                        <th class="py-3.5 px-6">Location</th>
                        <th class="py-3.5 px-6">Price</th>
                        <th class="py-3.5 px-6">Specs</th>
                        <th class="py-3.5 px-6">Type & Purpose</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($properties as $property)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- Property Title & Archived Badge -->
                            <td class="py-4 px-6 font-semibold text-slate-800">
                                <div class="flex items-center space-x-2">
                                    <span>{{ $property->title }}</span>
                                    @if($property->archived_at)
                                        <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                            Archived
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Location -->
                            <td class="py-4 px-6 text-slate-600 text-xs">
                                {{ $property->address }}, {{ $property->city }}, {{ $property->state }}
                            </td>

                            <!-- Price -->
                            <td class="py-4 px-6 font-bold text-slate-900">
                                ${{ number_format($property->price) }}
                            </td>

                            <!-- Specs -->
                            <td class="py-4 px-6 text-slate-500 text-xs">
                                {{ $property->bedrooms ?? 0 }} Bed • {{ $property->bathrooms ?? 0 }} Bath • {{ $property->area ?? 0 }} sqft
                            </td>

                            <!-- Type & Purpose -->
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-1.5">
                                    <span class="px-2 py-1 text-[11px] font-medium rounded-md bg-slate-100 text-slate-700">
                                        {{ ucfirst($property->type) }}
                                    </span>
                                    <span class="px-2 py-1 text-[11px] font-medium rounded-md {{ $property->purpose === 'rent' ? 'bg-purple-50 text-purple-700 border border-purple-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                                        For {{ ucfirst($property->purpose) }}
                                    </span>
                                </div>
                            </td>

                            <!-- Verification Status -->
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full 
                                    {{ $property->verification_status === 'Verified' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 
                                       ($property->verification_status === 'Rejected' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 
                                       ($property->verification_status === 'Under Review' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-amber-50 text-amber-700 border border-amber-200')) }}">
                                    {{ $property->verification_status ?? 'Pending' }}
                                    @if($property->is_verified)
                                        <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.properties.edit', $property) }}" class="inline-block px-3 py-1.5 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-medium rounded-lg transition">
                                    Edit 
                                </a>

                                <a href="{{ route('admin.properties.show', $property) }}" class="inline-block px-3 py-1.5 border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-medium rounded-lg transition">
                                    view 
                                </a>

                            </td>
                        </tr>
                    @empty
                        <!-- Empty State -->
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                    </div>
                                    <p class="text-slate-600 font-semibold text-base">No properties found</p>
                                    <p class="text-slate-400 text-xs mt-1">You haven't added any property records yet.</p>
                                    <a href="{{ route('admin.properties.create') }}" class="mt-3 text-indigo-600 hover:text-indigo-800 text-xs font-semibold">
                                        + Add your first property
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
    </div>
</x-admin-layout>