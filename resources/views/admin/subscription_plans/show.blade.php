<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Subscription Plan Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $subscriptionPlan->name }}</h3>

                    <div class="mb-4">
                        <p><strong>Description:</strong> {{ $subscriptionPlan->description }}</p>
                        <p><strong>Price:</strong> ${{ number_format($subscriptionPlan->price, 2) }}</p>
                        <p><strong>Duration:</strong> {{ ucfirst($subscriptionPlan->duration) }}</p>
                        <p><strong>Active:</strong> {{ $subscriptionPlan->is_active ? 'Yes' : 'No' }}</p>

                        @if ($subscriptionPlan->features)
                            <h4 class="font-semibold text-lg mt-4">Features:</h4>
                            <ul>
                                @foreach ($subscriptionPlan->features as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('admin.subscription-plans.edit', $subscriptionPlan) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Edit Plan</a>
                        <form action="{{ route('admin.subscription-plans.destroy', $subscriptionPlan) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Are you sure you want to delete this subscription plan?')">Delete Plan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>