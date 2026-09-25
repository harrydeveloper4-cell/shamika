<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight flex justify-between items-center">
            {{ __('My Properties') }}
            <a href="{{ route('vendor.properties.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                + Add Property
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 text-slate-800">
                    @if(session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2 shadow-sm">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2 shadow-sm">
                            <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ session('info') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Property</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Price / Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Details</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status / Verification</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse($properties as $property)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <!-- Property Title & Image -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="h-10 w-10 bg-slate-100 rounded-lg overflow-hidden shrink-0 flex items-center justify-center border border-slate-200">
                                                    @if($property->main_image_url)
                                                        <img src="{{ $property->main_image_url }}" alt="" class="w-full h-full object-cover" />
                                                    @elseif($property->images->first())
                                                        <img src="{{ $property->images->first()->image_url }}" alt="" class="w-full h-full object-cover" />
                                                    @else
                                                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-slate-800 text-sm">{{ $property->title }}</div>
                                                    <div class="text-slate-500 text-xs">{{ $property->address }}, {{ $property->city }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Price & Purpose/Type -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="font-bold text-indigo-600">${{ number_format($property->price) }}</div>
                                            <div class="flex gap-1.5 mt-1">
                                                <span class="px-2 py-0.5 text-[10px] font-medium rounded bg-slate-100 text-slate-700">{{ ucfirst($property->type) }}</span>
                                                <span class="px-2 py-0.5 text-[10px] font-medium rounded {{ $property->purpose === 'rent' ? 'bg-purple-50 text-purple-700 border border-purple-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">For {{ ucfirst($property->purpose) }}</span>
                                            </div>
                                        </td>

                                        <!-- Specs -->
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-600">
                                            <div><strong>{{ $property->bedrooms ?? 0 }}</strong> Beds | <strong>{{ $property->bathrooms ?? 0 }}</strong> Baths</div>
                                            <div class="text-slate-400 mt-0.5">{{ $property->area ?? 0 }} sqft</div>
                                        </td>

                                        <!-- Status / Inspection / Monitoring -->
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">
                                            @if($property->inspections()->count() > 0)
                                                <span class="px-2.5 py-1 font-semibold rounded-full inline-block
                                                    {{ $property->inspections[0]->recommendation === 'approve' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' :
                                                       ($property->inspections[0]->recommendation === 'rejecte' ? 'bg-rose-50 text-rose-700 border border-rose-100' : 'bg-blue-50 text-blue-700 border border-blue-100') }}">
                                                    Inspection: {{ ucfirst($property->inspections[0]->recommendation) }}
                                                </span>
                                            @elseif($property->monitoringRequests->count() > 0)
                                                @foreach($property->monitoringRequests as $mr)
                                                    <div class="text-slate-600 font-medium">Monitoring: <span class="text-indigo-600">{{ ucfirst($mr->status) }}</span></div>
                                                @endforeach
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-100 inline-block">
                                                    Required to verification
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <a href="{{ route('vendor.properties.show', $property) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs">View</a>
                                            <span class="text-slate-300">|</span>
                                            <a href="{{ route('vendor.properties.edit', $property) }}" class="text-slate-600 hover:text-slate-900 font-semibold text-xs">Edit</a>
                                            
                                            @if($property->monitoringRequests->count() == 0)
                                                <span class="text-slate-300">|</span>
                                                <form method="POST" action="{{ route('vendor.properties.submit-monitoring-request', $property) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-emerald-600 hover:text-emerald-900 font-semibold text-xs">Verify</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 text-sm">
                                            <p class="mb-2">You haven't added any properties yet.</p>
                                            <a href="{{ route('vendor.properties.create') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">+ Add your first property</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>