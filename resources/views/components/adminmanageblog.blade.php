@props(['posts'])

<div class="w-full max-w-7xl mx-auto min-h-[80vh] py-8" x-data="{
    showAddModal: false,
    showEditModal: false,
    showDeleteModal: false,
    showSuccessModal: false,
    successMessage: '',
    newPost: {
        title: '',
        content: '',
        is_published: false,
        image: null
    },
    selectedPost: {
        id: null,
        title: '',
        content: '',
        is_published: false,
        image: null
    },
    async createPost() {
        try {
            const formData = new FormData();
            formData.append('title', this.newPost.title);
            formData.append('content', this.newPost.content);
            formData.append('is_published', this.newPost.is_published ? '1' : '0');

            const imageFile = this.$refs.imageInput?.files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }

            const response = await fetch('/admin/blogs', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                this.showAddModal = false;
                this.showSuccessModal = true;
                this.successMessage = result.message;
                setTimeout(() => window.location.reload(), 1500);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while creating the post');
        }
    },
    async updatePost() {
        try {
            const formData = new FormData();
            formData.append('title', this.selectedPost.title);
            formData.append('content', this.selectedPost.content);
            formData.append('is_published', this.selectedPost.is_published ? '1' : '0');
            formData.append('_method', 'PATCH');

            const imageFile = this.$refs.editImageInput?.files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }

            const response = await fetch(`/admin/blogs/${this.selectedPost.id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                this.showEditModal = false;
                this.showSuccessModal = true;
                this.successMessage = result.message;
                setTimeout(() => window.location.reload(), 1500);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while updating the post');
        }
    },
    async deletePost() {
        try {
            const response = await fetch(`/admin/blogs/${this.selectedPost.id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                }
            });

            const result = await response.json();
            if (result.success) {
                this.showDeleteModal = false;
                this.showSuccessModal = true;
                this.successMessage = result.message;
                setTimeout(() => window.location.reload(), 1500);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while deleting the post');
        }
    },
    async togglePublish(id) {
        try {
            const response = await fetch(`/admin/blogs/${id}/toggle`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                }
            });
            const result = await response.json();
            if (result.success) {
                this.showSuccessModal = true;
                this.successMessage = result.message;
                setTimeout(() => window.location.reload(), 1500);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error toggling publish status');
        }
    }
}">
    <!-- Main Table Section -->
    <div class="bg-white rounded-lg shadow-md my-8 border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Blog Management</h2>
            <button @click="showAddModal = true"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Add Post
            </button>
        </div>

        <!-- Table Content -->
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Author</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($posts as $post)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $post->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $post->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $post->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span @click="togglePublish({{ $post->id }})"
                                        class="cursor-pointer px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $post->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button
                                        @click="selectedPost = { id: {{ $post->id }}, title: '{{ $post->title }}', content: '{{ $post->content }}', is_published: {{ $post->is_published ? 'true' : 'false' }} }; showEditModal = true;"
                                        class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                    <button
                                        @click="selectedPost = { id: {{ $post->id }} }; showDeleteModal = true;"
                                        class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No blog posts found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Post Modal -->
    <div x-show="showAddModal" x-cloak class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Post</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" x-model="newPost.title" required
                                class="mt-1 block w-full rounded-md border border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea x-model="newPost.content" required rows="6" class="mt-1 block w-full rounded-md border border-gray-300"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Image</label>
                            <input type="file" x-ref="imageInput" accept="image/*" required
                                class="mt-1 block w-full">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                <input type="checkbox" x-model="newPost.is_published"> Publish immediately
                            </label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button x-on:click.prevent.debounce.500ms="createPost()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Add Post
                    </button>
                    <button @click="showAddModal = false"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Post Modal -->
    <div x-show="showEditModal" x-cloak class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Post</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" x-model="selectedPost.title" required
                                class="mt-1 block w-full rounded-md border border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea x-model="selectedPost.content" required rows="6"
                                class="mt-1 block w-full rounded-md border border-gray-300"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Image</label>
                            <input type="file" x-ref="editImageInput" accept="image/*" class="mt-1 block w-full">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                <input type="checkbox" x-model="selectedPost.is_published"> Publish immediately
                            </label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button x-on:click.prevent.debounce.500ms="updatePost()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Update Post
                    </button>
                    <button @click="showEditModal = false"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" x-cloak class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Delete Post</h3>
                    <div class="space-y-4">
                        <p class="text-sm text-gray-500">Are you sure you want to delete this post? This action cannot
                            be undone.</p>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button x-on:click.prevent.debounce.500ms="deletePost()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button @click="showDeleteModal = false"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div x-show="showSuccessModal" x-cloak class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showSuccessModal" class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showSuccessModal"
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Success</h3>
                            <div class="mt-2">
                                <p x-text="successMessage"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="showSuccessModal = false" type="button"
                        class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
