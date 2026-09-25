<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Find Properties') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Filter Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200 mb-6">
                <div class="p-6 text-slate-800">
                    <form method="GET" action="{{ request()->routeIs('properties.search') ? route('properties.search') : route('renter.properties.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="request('location')" placeholder="City, Address, State..." />
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <x-input-label for="min_price" :value="__('Min Price')" />
                                <x-text-input id="min_price" class="block mt-1 w-full" type="number" name="min_price" :value="request('min_price')" min="0" />
                            </div>
                            <div>
                                <x-input-label for="max_price" :value="__('Max Price')" />
                                <x-text-input id="max_price" class="block mt-1 w-full" type="number" name="max_price" :value="request('max_price')" min="0" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <x-input-label for="bedrooms" :value="__('Beds')" />
                                <select id="bedrooms" name="bedrooms" class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    <option value="">Any</option>
                                    <option value="1" {{ request('bedrooms') === '1' ? 'selected' : '' }}>1+</option>
                                    <option value="2" {{ request('bedrooms') === '2' ? 'selected' : '' }}>2+</option>
                                    <option value="3" {{ request('bedrooms') === '3' ? 'selected' : '' }}>3+</option>
                                    <option value="4" {{ request('bedrooms') === '4' ? 'selected' : '' }}>4+</option>
                                    <option value="5" {{ request('bedrooms') === '5' ? 'selected' : '' }}>5+</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="bathrooms" :value="__('Baths')" />
                                <select id="bathrooms" name="bathrooms" class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    <option value="">Any</option>
                                    <option value="1" {{ request('bathrooms') === '1' ? 'selected' : '' }}>1+</option>
                                    <option value="2" {{ request('bathrooms') === '2' ? 'selected' : '' }}>2+</option>
                                    <option value="3" {{ request('bathrooms') === '3' ? 'selected' : '' }}>3+</option>
                                    <option value="4" {{ request('bathrooms') === '4' ? 'selected' : '' }}>4+</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <x-input-label for="type" :value="__('Type')" />
                                    <select id="type" name="type" class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        <option value="">Any</option>
                                        <option value="apartment" {{ request('type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                                        <option value="house" {{ request('type') === 'house' ? 'selected' : '' }}>House</option>
                                        <option value="villa" {{ request('type') === 'villa' ? 'selected' : '' }}>Villa</option>
                                        <option value="condo" {{ request('type') === 'condo' ? 'selected' : '' }}>Condo</option>
                                        <option value="studio" {{ request('type') === 'studio' ? 'selected' : '' }}>Studio</option>
                                        <option value="office" {{ request('type') === 'office' ? 'selected' : '' }}>Office</option>
                                        <option value="shop" {{ request('type') === 'shop' ? 'selected' : '' }}>Shop</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="purpose" :value="__('For')" />
                                    <select id="purpose" name="purpose" class="block mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        <option value="">Any</option>
                                        <option value="sell" {{ request('purpose') === 'sell' ? 'selected' : '' }}>Sale</option>
                                        <option value="rent" {{ request('purpose') === 'rent' ? 'selected' : '' }}>Rent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                    Search Properties
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Properties Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($properties as $property)
                    <div class="border border-slate-200 rounded-xl overflow-hidden hover:shadow-md transition-all bg-white flex flex-col justify-between">
                        @php
                            $show_route = request()->routeIs('properties.search') ? 'properties.view' : 'renter.properties.show';
                        @endphp
                        <div>
                            <a href="{{ route($show_route, $property) }}" class="block relative">
                                <div class="h-52 bg-gradient-to-br from-indigo-50 to-blue-100 flex items-center justify-center relative overflow-hidden">
                                    @if($property->is_verified)
                                        <div class="absolute top-3 left-3 bg-emerald-500 text-white text-[11px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1 shadow-sm">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                            Verified
                                        </div>
                                    @endif
                                    <svg class="h-20 w-20 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                            </a>
                            <div class="p-5">
                                <a href="{{ route($show_route, $property) }}">
                                    <h3 class="text-base font-semibold text-slate-800 hover:text-indigo-600 transition-colors mb-1 truncate">{{ $property->title }}</h3>
                                    <div class="text-xl font-bold text-indigo-600 mb-2">
                                        ${{ number_format($property->price) }}
                                        <span class="text-xs font-normal text-slate-500">{{ $property->purpose === 'rent' ? '/month' : '' }}</span>
                                    </div>
                                </a>
                                <p class="text-xs text-slate-500 mb-3 flex items-center gap-1 truncate">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    {{ $property->city }}, {{ $property->state }}
                                </p>
                                <div class="flex gap-4 text-xs text-slate-600 mb-4 pb-3 border-b border-slate-100">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                        {{ $property->bedrooms ?? 0 }} Beds
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" /></svg>
                                        {{ $property->bathrooms ?? 0 }} Baths
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" /></svg>
                                        {{ $property->area ?? 0 }} sqft
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="px-5 pb-5 pt-0 flex justify-between items-center">
                            <div class="flex gap-1.5">
                                <span class="px-2 py-0.5 text-[11px] font-medium rounded bg-slate-100 text-slate-600">{{ ucfirst($property->type) }}</span>
                                <span class="px-2 py-0.5 text-[11px] font-medium rounded {{ $property->purpose === 'rent' ? 'bg-purple-50 text-purple-700 border border-purple-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">For {{ ucfirst($property->purpose) }}</span>
                            </div>
                            <a href="{{ route($show_route, $property) }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold">View →</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-xl border border-slate-200 p-12 text-center shadow-sm">
                        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        <h3 class="text-base font-semibold text-slate-700 mb-1">No properties found</h3>
                        <p class="text-xs text-slate-500 mb-4">Try adjusting your search filters or browse our latest verified listings.</p>
                        <a href="{{ request()->routeIs('properties.search') ? route('properties.search') : route('renter.properties.index') }}" class="inline-flex items-center px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-md transition">Clear filters</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>