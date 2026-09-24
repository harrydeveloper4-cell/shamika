<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">All Users</h3>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions </th>
                                
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                @if($user->id != auth()->user()->id)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->getRoleNames()->implode(', ') }}</td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->status === 1)
                                            <span class="text-green-600">Approved</span>
                                        @elseif ($user->status === 2)
                                            <span class="text-yellow-600">Pending</span>
                                        @else
                                            <span class="text-red-600">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Edit Roles</a>
                                        
                                        @if ($user->hasRole('vendor'))

                                            @if ($user->status === 1)
                                            <form action="{{ route('admin.vendors.reject', $user) }}" method="POST" class="inline-block ml-2">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Reject Vendor</button>
                                            </form>
                                            @else
                                            <form action="{{ route('admin.vendors.approve', $user) }}" method="POST" class="inline-block ml-2">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-green-600 hover:text-green-900">Approve Vendor</button>
                                            </form>
                                            @endif
                                        @endif
                                        
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                   
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>