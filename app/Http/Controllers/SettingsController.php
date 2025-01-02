<?php

namespace App\Http\Controllers;

use App\Models\Clothe;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('settings', [
            'component' => 'userprofilesettings',
            'user' => Auth::user()
        ]);
    }

    public function wardrobe()
    {
        $clothes = Auth::user()->clothes()->get()->groupBy('category');
        return view('settings', [
            'component' => 'wardrobesettings',
            'clothes' => $clothes
        ]);
    }

    public function device()
    {
        $devices = Auth::user()->devices;
        return view('settings', [
            'component' => 'userdevicesettings',
            'devices' => $devices
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Require password verification for any changes
        $request->validate([
            'current_password' => 'required',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect'])
                ->withInput($request->except('current_password', 'new_password', 'new_password_confirmation'));
        }

        // Proceed with other validations if password check passes
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone_number' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            // Store new avatar with hashed name
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $hashedName = Str::random(40) . '_' . time() . '.' . $extension;

            $request->avatar->storeAs('avatars', $hashedName, 'public');
            $validated['avatar'] = $hashedName;
        }

        // Update basic info
        $user->update($validated);

        // Handle new password update if provided
        if ($request->filled('new_password')) {
            $request->validate([
                'new_password' => 'required|min:8|confirmed',
            ]);

            $user->update(['password' => Hash::make($request->new_password)]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    public function storeClothing(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:top,bottom,cap',
            'subcategory' => 'required|string',
            'color' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('clothes', 'public');
            $validated['image_path'] = $path;
        }

        $validated['user_id'] = Auth::id();

        Auth::user()->clothes()->create($validated);

        return back()->with('success', 'Clothing item added successfully!');
    }

    public function destroyClothing(Clothe $clothe)
    {
        if ($clothe->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Delete the image file
        if ($clothe->image_path) {
            Storage::disk('public')->delete($clothe->image_path);
        }

        $clothe->delete();

        return back()->with('success', 'Clothing item deleted successfully!');
    }

    public function storeDevice(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string|unique:userdevices,device_id',
            'device_name' => 'required|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_connected'] = false;
        Auth::user()->devices()->create($validated);

        return back()->with('success', 'Device added successfully!');
    }

    public function destroyDevice($id)
    {
        $device = Auth::user()->devices()->findOrFail($id);
        $device->delete();

        return back()->with('success', 'Device removed successfully!');
    }
}
