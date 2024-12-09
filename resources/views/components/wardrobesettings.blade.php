<div class="w-full max-w-3xl mx-auto">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md my-8 border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">My Wardrobe</h2>
        </div>

        <!-- Caps Section -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Caps</h3>
                <button onclick="openModal('cap')"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add New Cap</button>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach (['baseball', 'beanie'] as $subcat)
                    <div class="space-y-4">
                        <h4 class="font-medium text-gray-700">{{ ucfirst($subcat) }}</h4>
                        <div class="grid gap-4">
                            @forelse($clothes['cap'] ?? [] as $item)
                                @if ($item->subcategory === $subcat)
                                    <div class="border rounded-lg p-2 relative group">
                                        <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}"
                                            class="w-full h-32 object-contain mb-2">
                                        <p class="text-sm text-gray-600">{{ $item->name }}</p>
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                            <form action="{{ route('settings.wardrobe.delete', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p class="text-gray-500 text-sm">No items yet</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tops Section -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Tops</h3>
                <button onclick="openModal('top')"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add New Top</button>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach (['long_sleeve', 'hoodie', 't_shirt'] as $subcat)
                    <div class="space-y-4">
                        <h4 class="font-medium text-gray-700">{{ str_replace('_', ' ', ucfirst($subcat)) }}</h4>
                        <div class="grid gap-4">
                            @forelse($clothes['top'] ?? [] as $item)
                                @if ($item->subcategory === $subcat)
                                    <div class="border rounded-lg p-2 relative group">
                                        <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}"
                                            class="w-full h-32 object-contain mb-2">
                                        <p class="text-sm text-gray-600">{{ $item->name }}</p>
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                            <form action="{{ route('settings.wardrobe.delete', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p class="text-gray-500 text-sm">No items yet</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Bottoms Section -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Bottoms</h3>
                <button onclick="openModal('bottom')"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add New Bottom</button>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach (['jeans', 'shorts', 'joggers'] as $subcat)
                    <div class="space-y-4">
                        <h4 class="font-medium text-gray-700">{{ ucfirst($subcat) }}</h4>
                        <div class="grid gap-4">
                            @forelse($clothes['bottom'] ?? [] as $item)
                                @if ($item->subcategory === $subcat)
                                    <div class="border rounded-lg p-2 relative group">
                                        <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}"
                                            class="w-full h-32 object-contain mb-2">
                                        <p class="text-sm text-gray-600">{{ $item->name }}</p>
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                            <form action="{{ route('settings.wardrobe.delete', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p class="text-gray-500 text-sm">No items yet</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add Clothing Modal -->
    <div id="addClothingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Add New Clothing Item</h3>
                <form id="clothingForm" action="{{ route('settings.wardrobe.store') }}" method="POST"
                    enctype="multipart/form-data" class="mt-4">
                    @csrf
                    <input type="hidden" name="category" id="categoryInput">

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                        <input type="text" name="name" class="shadow border rounded w-full py-2 px-3" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Subcategory</label>
                        <select name="subcategory" id="subcategorySelect" class="shadow border rounded w-full py-2 px-3"
                            required>
                            <!-- Options will be populated via JavaScript -->
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Color</label>
                        <input type="text" name="color" class="shadow border rounded w-full py-2 px-3">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Image</label>
                        <input type="file" name="image" accept="image/*"
                            class="shadow border rounded w-full py-2 px-3" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" class="shadow border rounded w-full py-2 px-3"></textarea>
                    </div>

                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="closeModal()"
                            class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const categories = @json(\App\Models\Clothe::CATEGORIES);

        function openModal(category) {
            document.getElementById('addClothingModal').classList.remove('hidden');
            document.getElementById('categoryInput').value = category;
            populateSubcategories(category);
        }

        function closeModal() {
            document.getElementById('addClothingModal').classList.add('hidden');
        }

        function populateSubcategories(category) {
            const select = document.getElementById('subcategorySelect');
            select.innerHTML = '';

            categories[category].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub;
                option.textContent = sub.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                select.appendChild(option);
            });
        }
    </script>
</div>
