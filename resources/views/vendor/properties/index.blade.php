<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight flex justify-between items-center">
            {{ __('My Properties') }}
            <a href="{{ route('vendor.properties.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Add Property
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                            {{ session('info') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($properties as $property)
                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                                <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                                    @if($property->main_image_url)
                                        <img src="{{ $property->main_image_url }}" alt="{{ $property->title }}" class="w-full h-full object-cover" />
                                    @elseif($property->images->first())
                                        <img src="{{ $property->images->first()->image_url }}" alt="{{ $property->title }}" class="w-full h-full object-cover" />
                                    @else
                                        <svg class="h-20 w-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $property->title }}</h3>
                                        <span class="text-lg font-bold text-blue-600">${{ number_format($property->price) }}</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-2">{{ $property->address }}, {{ $property->city }}, {{ $property->state }}</p>
                                    <div class="flex gap-2 text-xs text-gray-500 mb-3">
                                        <span>{{ $property->bedrooms ?? 0 }} Beds</span>
                                        <span>•</span>
                                        <span>{{ $property->bathrooms ?? 0 }} Baths</span>
                                        <span>•</span>
                                        <span>{{ $property->area ?? 0 }} sqft</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <span class="px-2 py-0.5 text-xs rounded bg-gray-100 text-gray-700">{{ ucfirst($property->type) }}</span>
                                        <span class="px-2 py-0.5 text-xs rounded {{ $property->purpose === 'rent' ? 'bg-purple-100 text-purple-700' : 'bg-orange-100 text-orange-700' }}">For {{ ucfirst($property->purpose) }}</span>
                                        <span class="px-2 py-0.5 text-xs rounded
                                            {{ $property->verification_status === 'Verified' ? 'bg-green-100 text-green-700' :
                                               ($property->verification_status === 'Rejected' ? 'bg-red-100 text-red-700' :
                                               ($property->verification_status === 'Under Review' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700')) }}">
                                            {{ $property->verification_status ?? 'Pending' }}
                                            @if($property->is_verified) ✓ @endif
                                        </span>
                                        @if($property->archived_at)
                                            <span class="px-2 py-0.5 text-xs rounded bg-gray-300 text-gray-700">Archived</span>
                                        @endif
                                    </div>
                                    <div class="flex gap-2 text-sm">
                                        <a href="{{ route('vendor.properties.edit', $property) }}" class="flex-1 text-center px-3 py-1.5 border border-gray-300 rounded-md hover:bg-gray-50">Edit</a>
                                        @if(!$property->archived_at)
                                            <form method="POST" action="{{ route('vendor.properties.archive', $property) }}" class="flex-1" onsubmit="return confirm('Are you sure you want to archive this property?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="w-full text-center px-3 py-1.5 border border-red-300 text-red-600 rounded-md hover:bg-red-50">Archive</button>
                                            </form>
                                        @endif
                                        @if(!$property->archived_at && $property->verification_status !== 'Verified' && $property->verification_status !== 'Under Review')
                                            <form method="POST" action="{{ route('vendor.properties.submit-monitoring-request', $property) }}" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full text-center px-3 py-1.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Request Verify</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12 text-gray-500">
                                <p class="mb-4">You haven't added any properties yet.</p>
                                <a href="{{ route('vendor.properties.create') }}" class="text-blue-600 hover:text-blue-800 font-medium">+ Add your first property</a>
                            </div>
                        @endforelse
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
