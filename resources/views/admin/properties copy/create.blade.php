<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
             {{ __('Add New Property') }} ADMIN
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


    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.properties.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-input-label for="title" :value="__('Property Title')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required placeholder="e.g., Beautiful 3BHK Apartment in Downtown" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Description (optional)')" />
                                <textarea id="description" name="description" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Describe your property in detail...">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="type" :value="__('Property Type')" />
                                <select id="type" name="type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Type</option>
                                    <option value="apartment" {{ old('type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                                    <option value="house" {{ old('type') === 'house' ? 'selected' : '' }}>House</option>
                                    <option value="villa" {{ old('type') === 'villa' ? 'selected' : '' }}>Villa</option>
                                    <option value="condo" {{ old('type') === 'condo' ? 'selected' : '' }}>Condo</option>
                                    <option value="townhouse" {{ old('type') === 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                                    <option value="studio" {{ old('type') === 'studio' ? 'selected' : '' }}>Studio</option>
                                    <option value="office" {{ old('type') === 'office' ? 'selected' : '' }}>Office</option>
                                    <option value="shop" {{ old('type') === 'shop' ? 'selected' : '' }}>Shop</option>
                                    <option value="warehouse" {{ old('type') === 'warehouse' ? 'selected' : '' }}>Warehouse</option>
                                    <option value="land" {{ old('type') === 'land' ? 'selected' : '' }}>Land</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="purpose" :value="__('Purpose')" />
                                <select id="purpose" name="purpose" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Purpose</option>
                                    <option value="sell" {{ old('purpose') === 'sell' ? 'selected' : '' }}>For Sale</option>
                                    <option value="rent" {{ old('purpose') === 'rent' ? 'selected' : '' }}>For Rent</option>
                                </select>
                                <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="price" :value="__('Price')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" min="0" name="price" :value="old('price')" required placeholder="e.g., 250000" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="bedrooms" :value="__('Bedrooms')" />
                                    <x-text-input id="bedrooms" class="block mt-1 w-full" type="number" min="0" name="bedrooms" :value="old('bedrooms', 0)" />
                                    <x-input-error :messages="$errors->get('bedrooms')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="bathrooms" :value="__('Bathrooms')" />
                                    <x-text-input id="bathrooms" class="block mt-1 w-full" type="number" min="0" step="0.5" name="bathrooms" :value="old('bathrooms', 0)" />
                                    <x-input-error :messages="$errors->get('bathrooms')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="area" :value="__('Area (sqft)')" />
                                    <x-text-input id="area" class="block mt-1 w-full" type="number" min="0" name="area" :value="old('area', 0)" />
                                    <x-input-error :messages="$errors->get('area')" class="mt-2" />
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <h4 class="font-medium text-gray-700 mb-3 border-b pb-1">Location Details</h4>
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="address" :value="__('Street Address')" />
                                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required placeholder="e.g., 123 Main Street" />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required placeholder="e.g., New York" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="state" :value="__('State / Province')" />
                                <x-text-input id="state" class="block mt-1 w-full" type="text" name="state" :value="old('state')" required placeholder="e.g., NY" />
                                <x-input-error :messages="$errors->get('state')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="zip_code" :value="__('ZIP / Postal Code')" />
                                <x-text-input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code" :value="old('zip_code')" required placeholder="e.g., 10001" />
                                <x-input-error :messages="$errors->get('zip_code')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="country" :value="__('Country')" />
                                <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country', 'United States')" required />
                                <x-input-error :messages="$errors->get('country')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('vendor.properties.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                Cancel
                            </a>
                            <x-primary-button class="ml-3">
                                {{ __('Save Property') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
