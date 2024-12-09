<div class="w-full max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md my-8 border border-gray-200 z[15]">
        <!-- Profile Header -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">Profile Settings</h2>
        </div>

        <form method="POST" action="{{ route('settings.profile.update') }}" enctype="multipart/form-data">
            @csrf
            <!-- Password Verification (Required) -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium mb-4">Password Verification</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" name="current_password" required
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('current_password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Profile Picture Section -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-24 h-24 relative">
                        <img id="profileImage" src="{{ Auth::user()->avatar_url }}"
                            class="rounded-full w-full h-full object-cover border-2 border-gray-200">
                        <label class="absolute bottom-0 right-0 bg-blue-500 p-2 rounded-full cursor-pointer">
                            <input type="file" name="avatar" class="hidden" id="profilePictureInput"
                                accept="image/*">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                        </label>
                    </div>
                    <div class="ml-6">
                        <h3 class="text-lg font-medium">Profile Picture</h3>
                        <p class="text-sm text-gray-500">JPG, GIF or PNG. Max size of 800K</p>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium mb-4">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" name="phone_number"
                            value="{{ old('phone_number', Auth::user()->phone_number) }}"
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('phone_number')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" value="{{ old('location', Auth::user()->location) }}"
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('location')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- New Password Section (Optional) -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium mb-4">Change Password (Optional)</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="new_password"
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('new_password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation"
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Save Button -->
            <div class="p-6 flex justify-end">
                <button type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
