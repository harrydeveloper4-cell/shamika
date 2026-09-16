<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight flex justify-between items-center">
            {{ __('Edit Property') }}
            <a href="{{ route('vendor.properties.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to Properties</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($property->archived_at)
                        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-6">
                            <strong>Note:</strong> This property is archived. You can still edit the details, but it may not be visible to renters.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('vendor.properties.update', $property) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-input-label for="title" :value="__('Property Title')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $property->title)" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Description (optional)')" />
                                <textarea id="description" name="description" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $property->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="type" :value="__('Property Type')" />
                                <select id="type" name="type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Type</option>
                                    <option value="apartment" {{ old('type', $property->type) === 'apartment' ? 'selected' : '' }}>Apartment</option>
                                    <option value="house" {{ old('type', $property->type) === 'house' ? 'selected' : '' }}>House</option>
                                    <option value="villa" {{ old('type', $property->type) === 'villa' ? 'selected' : '' }}>Villa</option>
                                    <option value="condo" {{ old('type', $property->type) === 'condo' ? 'selected' : '' }}>Condo</option>
                                    <option value="townhouse" {{ old('type', $property->type) === 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                                    <option value="studio" {{ old('type', $property->type) === 'studio' ? 'selected' : '' }}>Studio</option>
                                    <option value="office" {{ old('type', $property->type) === 'office' ? 'selected' : '' }}>Office</option>
                                    <option value="shop" {{ old('type', $property->type) === 'shop' ? 'selected' : '' }}>Shop</option>
                                    <option value="warehouse" {{ old('type', $property->type) === 'warehouse' ? 'selected' : '' }}>Warehouse</option>
                                    <option value="land" {{ old('type', $property->type) === 'land' ? 'selected' : '' }}>Land</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="purpose" :value="__('Purpose')" />
                                <select id="purpose" name="purpose" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Purpose</option>
                                    <option value="sell" {{ old('purpose', $property->purpose) === 'sell' ? 'selected' : '' }}>For Sale</option>
                                    <option value="rent" {{ old('purpose', $property->purpose) === 'rent' ? 'selected' : '' }}>For Rent</option>
                                </select>
                                <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="price" :value="__('Price')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" min="0" name="price" :value="old('price', $property->price)" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="bedrooms" :value="__('Bedrooms')" />
                                    <x-text-input id="bedrooms" class="block mt-1 w-full" type="number" min="0" name="bedrooms" :value="old('bedrooms', $property->bedrooms)" />
                                    <x-input-error :messages="$errors->get('bedrooms')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="bathrooms" :value="__('Bathrooms')" />
                                    <x-text-input id="bathrooms" class="block mt-1 w-full" type="number" min="0" step="0.5" name="bathrooms" :value="old('bathrooms', $property->bathrooms)" />
                                    <x-input-error :messages="$errors->get('bathrooms')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="area" :value="__('Area (sqft)')" />
                                    <x-text-input id="area" class="block mt-1 w-full" type="number" min="0" name="area" :value="old('area', $property->area)" />
                                    <x-input-error :messages="$errors->get('area')" class="mt-2" />
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <h4 class="font-medium text-gray-700 mb-3 border-b pb-1">Property Images</h4>
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="main_image" :value="__('Main Image (Featured)')" />
                                <div class="mt-1 flex items-start gap-4">
                                    <div class="w-32 h-32 rounded-lg border-2 border-dashed border-gray-300 overflow-hidden bg-gray-50 flex items-center justify-center shrink-0">
                                        @if($property->main_image_url)
                                            <img id="main_image_preview" src="{{ $property->main_image_url }}" class="w-full h-full object-cover" alt="Main Image" />
                                        @else
                                            <img id="main_image_preview" class="w-full h-full object-cover hidden" alt="Preview" />
                                            <span id="main_image_placeholder" class="text-xs text-gray-400 px-2 text-center">No Image</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <input id="main_image" type="file" name="main_image" accept="image/*" onchange="previewMainImage(this)"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                        @if($property->main_image)
                                            <label class="inline-flex items-center gap-2 text-sm text-red-600">
                                                <input type="checkbox" name="remove_main_image" value="1" class="rounded" />
                                                Remove current main image
                                            </label>
                                        @endif
                                        <p class="text-xs text-gray-500">Upload a featured image (JPEG, PNG, GIF, WEBP. Max 5MB).</p>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('main_image')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label :value="__('Current Gallery Images')" />
                                @if($property->images->count())
                                    <div class="mt-2 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                                        @foreach($property->images as $img)
                                            <div class="relative aspect-square rounded-md border border-gray-200 overflow-hidden bg-gray-50 group">
                                                <img src="{{ $img->image_url }}" class="w-full h-full object-cover" alt="Gallery" />
                                                <label class="absolute inset-0 bg-black/50 text-white text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer transition">
                                                    <input type="checkbox" name="remove_images[]" value="{{ $img->id }}" class="mr-1.5" />
                                                    Remove
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500">Hover on image & check to mark for removal on save.</p>
                                @else
                                    <p class="mt-1 text-xs text-gray-400 italic">No gallery images yet.</p>
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="gallery_images" :value="__('Add More Gallery Images')" />
                                <input id="gallery_images" type="file" name="gallery_images[]" multiple accept="image/*" onchange="previewGalleryImages(this)"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />
                                <p class="mt-1 text-xs text-gray-500">Upload up to 20 additional images (Max 5MB each).</p>
                                <div id="gallery_preview" class="mt-3 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3"></div>
                                <x-input-error :messages="$errors->get('gallery_images.*')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <h4 class="font-medium text-gray-700 mb-3 border-b pb-1">Location Details</h4>
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="address" :value="__('Street Address')" />
                                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address', $property->address)" required />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city', $property->city)" required />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="state" :value="__('State / Province')" />
                                <x-text-input id="state" class="block mt-1 w-full" type="text" name="state" :value="old('state', $property->state)" required />
                                <x-input-error :messages="$errors->get('state')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="zip_code" :value="__('ZIP / Postal Code')" />
                                <x-text-input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code" :value="old('zip_code', $property->zip_code)" required />
                                <x-input-error :messages="$errors->get('zip_code')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="country" :value="__('Country')" />
                                <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country', $property->country)" required />
                                <x-input-error :messages="$errors->get('country')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('vendor.properties.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                Cancel
                            </a>
                            <x-primary-button class="ml-3">
                                {{ __('Update Property') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewMainImage(input) {
            const img = document.getElementById('main_image_preview');
            const placeholder = document.getElementById('main_image_placeholder');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewGalleryImages(input) {
            const preview = document.getElementById('gallery_preview');
            preview.innerHTML = '';
            if (input.files) {
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    const div = document.createElement('div');
                    div.className = 'aspect-square rounded-md border border-gray-200 overflow-hidden bg-gray-50';
                    const img = document.createElement('img');
                    img.className = 'w-full h-full object-cover';
                    reader.onload = function(e) { img.src = e.target.result; };
                    reader.readAsDataURL(file);
                    div.appendChild(img);
                    preview.appendChild(div);
                });
            }
        }
    </script>
</x-app-layout>
