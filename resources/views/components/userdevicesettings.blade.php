<div class="p-6 bg-white backdrop-blur-md rounded-xl shadow-lg z-[15]">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Device Management</h2>
        <p class="text-gray-600">Manage your connected SkySense devices here.</p>
    </div>

    <!-- Add Device Form -->
    <div class="mb-8 p-4 bg-white/50 rounded-lg">
        <h3 class="text-lg font-semibold mb-4">Add New Device</h3>
        <form class="space-y-4" action="{{ route('settings.device.store') }}" method="POST">
            @csrf
            <div>
                <label for="device_id" class="block text-sm font-medium text-gray-700">Device ID</label>
                <input type="text" id="device_id" name="device_id"
                    class="mt-1 block w-full rounded-md border-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="device_name" class="block text-sm font-medium text-gray-700">Device Name</label>
                <input type="text" id="device_name" name="device_name"
                    class="mt-1 block w-full rounded-md border-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                Add Device
            </button>
        </form>
    </div>

    <!-- Device List -->
    <div class="space-y-4">
        <h3 class="text-lg font-semibold">Your Devices</h3>

        <!-- Device Cards -->
        <div class="grid gap-4 md:grid-cols-2">
            @forelse ($devices as $device)
                <div class="p-4 bg-white/50 rounded-lg shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-semibold">{{ $device->device_name }}</h4>
                            <p class="text-sm text-gray-600">ID: {{ $device->device_id }}</p>
                            <p class="text-sm {{ $device->is_connected ? 'text-green-600' : 'text-red-600' }} mt-2">
                                Status: {{ $device->is_connected ? 'Connected' : 'Disconnected' }}
                            </p>
                        </div>
                        <form action="{{ route('settings.device.delete', $device->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No devices added yet.</p>
            @endforelse
        </div>
    </div>
</div>
