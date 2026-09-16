<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Edit Commission Setting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Commission Setting: {{ $commissionSetting->name }}</h3>

                    <form method="POST" action="{{ route('admin.commission-settings.update', $commissionSetting) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Setting Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $commissionSetting->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Type')" />
                            <select name="type" id="type" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="fixed" {{ old('type', $commissionSetting->type) === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                <option value="percentage" {{ old('type', $commissionSetting->type) === 'percentage' ? 'selected' : '' }}>Percentage</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="value" :value="__('Value')" />
                            <x-text-input id="value" class="block mt-1 w-full" type="number" step="0.01" name="value" :value="old('value', $commissionSetting->value)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('value')" />
                        </div>

                        <div class="mb-4 flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $commissionSetting->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <x-input-label for="is_active" class="ml-2 text-sm text-gray-600" :value="__('Is Active')" />
                            <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Setting') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>