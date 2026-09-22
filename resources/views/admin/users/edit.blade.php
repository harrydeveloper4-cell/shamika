<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Edit User Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Editing Roles for {{ $user->name }}</h3>

                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('User Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="email" :value="__('User Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required autocomplete="username" disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label :value="__('Roles')" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach ($roles as $role)
                                    @php
                                        $hasRole = $user->hasRole($role->name);
                                    @endphp
                                    <label for="role_{{ $role->name }}" class="flex items-center p-3 rounded-lg border cursor-pointer transition-all duration-150 {{ $hasRole ? 'bg-indigo-50 border-indigo-300 shadow-sm' : 'bg-white border-gray-200 hover:bg-gray-50' }}">
                                        <input type="checkbox" name="roles[]" id="role_{{ $role->name }}" value="{{ $role->name }}" {{ $hasRole ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 focus:ring-2">
                                        <span class="ml-3 text-sm font-medium {{ $hasRole ? 'text-indigo-900 font-semibold' : 'text-gray-700' }}">
                                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('roles')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Roles') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>