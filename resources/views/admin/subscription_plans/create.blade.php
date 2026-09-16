<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Create Subscription Plan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">New Subscription Plan</h3>

                    <form method="POST" action="{{ route('admin.subscription-plans.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Plan Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-textarea id="description" name="description" class="block mt-1 w-full" rows="3">{{ old('description') }}</x-textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('price')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="duration" :value="__('Duration')" />
                            <select name="duration" id="duration" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="monthly" {{ old('duration') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ old('duration') === 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('duration')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="features" :value="__('Features (comma separated)')" />
                            <x-text-input id="features" class="block mt-1 w-full" type="text" name="features" :value="old('features')" placeholder="Feature 1, Feature 2" />
                            <x-input-error class="mt-2" :messages="$errors->get('features')" />
                        </div>

                        <div class="mb-4 flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <x-input-label for="is_active" class="ml-2 text-sm text-gray-600" :value="__('Is Active')" />
                            <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Create Plan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>