<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight flex justify-between items-center">
            {{ __('Property Details') }}
            @php
                $back_route = request()->routeIs('properties.view') ? 'properties.search' : 'renter.properties.index';
            @endphp
            <a href="{{ route($back_route) }}" class="text-sm text-slate-100 hover:text-gray-900">← Back to Search</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="h-96 bg-gradient-to-br from-indigo-50 via-blue-50 to-purple-50 flex items-center justify-center relative">
                            @if($property->is_verified)
                                <div class="absolute top-4 left-4 bg-green-500 text-white text-sm font-bold px-3 py-1.5 rounded-full flex items-center gap-2 shadow-md">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                    Verified Property
                                </div>
                            @endif
                            <span class="absolute top-4 right-4 px-3 py-1.5 text-sm rounded-full {{ $property->purpose === 'rent' ? 'bg-purple-100 text-purple-700' : 'bg-orange-100 text-orange-700' }} font-semibold">
                                For {{ ucfirst($property->purpose) }}
                            </span>
                            <svg class="h-40 w-40 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $property->title }}</h1>
                                    <p class="text-gray-600 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        {{ $property->address }}, {{ $property->city }}, {{ $property->state }} {{ $property->zip_code }}, {{ $property->country }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-bold text-indigo-600">${{ number_format($property->price) }}</div>
                                    <div class="text-sm text-gray-500">{{ $property->purpose === 'rent' ? 'per month' : 'total price' }}</div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-6 my-4 border-y border-gray-100">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900">{{ $property->bedrooms ?? 0 }}</div>
                                    <div class="text-sm text-gray-500">Bedrooms</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900">{{ $property->bathrooms ?? 0 }}</div>
                                    <div class="text-sm text-gray-500">Bathrooms</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900">{{ $property->area ?? 0 }}</div>
                                    <div class="text-sm text-gray-500">Sqft</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900 capitalize">{{ $property->type }}</div>
                                    <div class="text-sm text-gray-500">Type</div>
                                </div>
                            </div>

                            @if($property->description)
                                <div class="mb-6">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-3">About this property</h2>
                                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $property->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">Listed By</h3>
                            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <span class="text-indigo-700 font-bold text-lg">
                                        {{ strtoupper(substr($property->user->name ?? 'O', 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $property->user->name ?? 'Owner' }}</div>
                                    <div class="text-sm text-gray-500">{{ $property->owner_type === 'admin' ? 'Platform Verified' : 'Property Owner' }}</div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <button class="w-full inline-flex items-center justify-center px-4 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Book a Viewing
                                </button>
                                <button class="w-full inline-flex items-center justify-center px-4 py-3 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:bg-gray-50 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Contact Owner
                                </button>
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-100 space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Property ID:</span>
                                    <span class="font-medium">#{{ $property->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Verification:</span>
                                    <span class="font-medium {{ $property->is_verified ? 'text-green-600' : 'text-yellow-600' }}">
                                        {{ $property->verification_status ?? 'Pending' }}
                                        @if($property->is_verified) ✓ @endif
                                    </span>
                                </div>
                                @if($property->published_at)
                                    <div class="flex justify-between">
                                        <span>Listed on:</span>
                                        <span class="font-medium">{{ $property->published_at->toFormattedDateString() }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
