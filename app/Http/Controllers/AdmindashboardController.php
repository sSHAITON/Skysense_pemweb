<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

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

    public function blogs()
    {
        try {
            $posts = Post::with('user')->latest()->get();

            return view('admindashboard', [
                'component' => 'adminmanageblog',
                'posts' => $posts ?? collect()
            ]);
        } catch (\Exception $e) {
            return view('admindashboard', [
                'component' => 'adminmanageblog',
                'posts' => collect()
            ]);
        }
    }

    public function storeBlog(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_published' => 'required|boolean'
            ]);

            $baseSlug = \Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;

            while (Post::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            $imageUrl = null;
            if ($request->hasFile('image')) {
                $imageUrl = $request->file('image')->store('blog-images', 'public');
            }

            if (!$imageUrl) {
                throw new \Exception('Failed to upload image');
            }

            $post = Post::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'image_url' => $imageUrl,
                'user_id' => auth()->id(),
                'slug' => $slug,
                'is_published' => $validated['is_published']
            ]);

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Blog post created successfully!'
            ], 201);
        } catch (\Exception $e) {
            \DB::rollBack();
            if (isset($imageUrl)) {
                Storage::disk('public')->delete($imageUrl);
            }
            if (isset($imageUrl)) {
                Storage::disk('public')->delete($imageUrl);
            }
            return response()->json([
                'success' => false,
                'message' => 'Error creating blog post: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateBlog(Request $request, Post $post)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_published' => 'required|boolean'
            ]);

            $data = [
                'title' => $validated['title'],
                'content' => $validated['content'],
                'slug' => \Str::slug($validated['title']),
                'is_published' => $validated['is_published']
            ];

            if ($request->hasFile('image')) {
                // Delete old image
                if ($post->image_url) {
                    Storage::disk('public')->delete($post->image_url);
                }
                // Store new image
                $data['image_url'] = $request->file('image')->store('blog-images', 'public');
            }

            $post->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Blog post updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating blog post: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyBlog(Post $post)
    {
        try {
            if ($post->image_url) {
                Storage::disk('public')->delete($post->image_url);
            }
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Blog post deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting blog post: ' . $e->getMessage()
            ], 500);
        }
    }

    public function togglePublish(Post $post)
    {
        $post->update(['is_published' => !$post->is_published]);

        return response()->json([
            'success' => true,
            'message' => 'Blog post status updated successfully!'
        ]);
    }

    public function getBlog(Post $post)
    {
        try {
            $post->load('user');

            if (!$post) {
                throw new \Exception('Post not found');
            }

            return response()->json([
                'success' => true,
                'post' => $post,
                'message' => 'Post retrieved successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching blog post: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching blog post: ' . $e->getMessage()
            ], 500);
        }
    }
}
