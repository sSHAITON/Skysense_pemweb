<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdmindashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $deviceCount = UserDevice::count();

        return view('admindashboard', [
            'component' => 'admindashboard',
            'userCount' => $userCount,
            'deviceCount' => $deviceCount,
        ]);
    }

    public function users()
    {
        $users = User::all();
        return view('admindashboard', [
            'component' => 'adminusermanagement',
            'users' => $users
        ]);
    }

    public function devices()
    {
        $devices = UserDevice::with('user')->get();
        return view('admindashboard', [
            'component' => 'admindevicemanagement',
            'devices' => $devices
        ]);
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'is_admin' => 'required|boolean'
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!'
        ]);
    }

    public function storeUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'phone_number' => 'nullable|string|max:20',
                'location' => 'nullable|string|max:255',
                'is_admin' => 'required|boolean'
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'phone_number' => $validated['phone_number'],
                'location' => $validated['location'],
                'is_admin' => $validated['is_admin']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyUser(User $user)
    {
        try {
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account!'
                ], 403);
            }

            if ($user->avatar) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeDevice(Request $request)
    {
        try {
            $validated = $request->validate([
                'device_id' => 'required|string|unique:userdevices,device_id',
                'device_name' => 'required|string|max:255',
                'user_id' => 'required|exists:users,id'
            ]);

            UserDevice::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Device added successfully!'
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add device: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyDevice(UserDevice $device)
    {
        try {
            $device->delete();

            return response()->json([
                'success' => true,
                'message' => 'Device deleted successfully!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete device: ' . $e->getMessage()
            ], 500);
        }
    }
}
