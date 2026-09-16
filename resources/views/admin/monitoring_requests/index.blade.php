<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Monitoring Requests') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden ">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h3 class="text-base font-semibold text-slate-800">All Monitoring Requests</h3>
            </div>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Inspector</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($monitoringRequests as $request)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $request->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap"><a href="#" class="text-indigo-600 hover:text-indigo-900">{{ $request->property->title }}</a></td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $request->vendor->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($request->status) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $request->assignedInspector ? $request->assignedInspector->name : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.monitoring-requests.show', $request) }}" class="text-indigo-600 hover:text-indigo-900">Review / Assign</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                
        </div>
    </div>
</x-admin-layout>