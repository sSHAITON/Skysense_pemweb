<div class="container mx-auto px-4 py-8 mb-16 relative z-15">
    <div class="max-w-4xl mx-auto bg-blue-200/30 backdrop-blur-md rounded-3xl shadow-lg p-6">
        <h2 class="text-2xl font-semibold mb-6 text-center">Today's Outfit Recommendation</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Cap Section -->
            <div class="flex flex-col items-center" id="cap-section">
                <div class="w-48 h-48 rounded-lg flex items-center justify-center mb-4 bg-white/50">
                    <img src="" alt="Cap" class="max-w-full max-h-full object-contain outfit-image"
                        id="cap-image">
                </div>
                <button onclick="changeOutfit('cap')"
                    class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-full transition-colors">
                    Change Cap
                </button>
            </div>

            <!-- Top Section -->
            <div class="flex flex-col items-center" id="top-section">
                <div class="w-48 h-48 rounded-lg flex items-center justify-center mb-4 bg-white/50">
                    <img src="" alt="Top" class="max-w-full max-h-full object-contain outfit-image"
                        id="top-image">
                </div>
                <button onclick="changeOutfit('top')"
                    class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-full transition-colors">
                    Change Top
                </button>
            </div>

            <!-- Bottom Section -->
            <div class="flex flex-col items-center" id="bottom-section">
                <div class="w-48 h-48 rounded-lg flex items-center justify-center mb-4 bg-white/50">
                    <img src="" alt="Bottom" class="max-w-full max-h-full object-contain outfit-image"
                        id="bottom-image">
                </div>
                <button onclick="changeOutfit('bottom')"
                    class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-full transition-colors">
                    Change Bottom
                </button>
            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-lg mb-4">Weather condition: <span class="font-semibold weather-status">Loading...</span></p>
        </div>
    </div>
</div>

<!-- Add jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let outfitRecommendations = {
        cap: [],
        top: [],
        bottom: []
    };

    let currentOutfitIndex = {
        cap: 0,
        top: 0,
        bottom: 0
    };

    function updateOutfitDisplay(category) {
        const items = outfitRecommendations[category];
        if (items && items.length > 0) {
            const index = currentOutfitIndex[category];
            const item = items[index];
            const imgElement = document.getElementById(`${category}-image`);
            imgElement.src = `/storage/${item.image_path}`;
            imgElement.alt = item.name;
        }
    }

    function changeOutfit(category) {
        const items = outfitRecommendations[category];
        if (items && items.length > 0) {
            currentOutfitIndex[category] = (currentOutfitIndex[category] + 1) % items.length;
            updateOutfitDisplay(category);
        }
    }

    function updateOutfitRecommendations() {
        const deviceId = localStorage.getItem('selectedDeviceId');
        const userId = localStorage.getItem('selectedUserId');

        if (!deviceId || !userId) {
            $('.weather-status').text('No device selected');
            return;
        }

        $.ajax({
            url: '{{ route('wardrobe.recommendations') }}',
            method: 'GET',
            data: {
                device_id: deviceId,
                user_id: userId
            },
            success: function(response) {
                if (response.error) {
                    console.error('Recommendation error:', response.error);
                    $('.weather-status').text(response.error);
                    return;
                }

                outfitRecommendations = response.recommendations;
                $('.weather-status').text(
                    `${response.weather.condition}, ${response.weather.temperature}°C`
                );

                // Reset indices and update display
                Object.keys(outfitRecommendations).forEach(category => {
                    currentOutfitIndex[category] = 0;
                    if (outfitRecommendations[category].length === 0) {
                        $(`#${category}-image`).attr('src', '/img/no-image.png');
                        $(`#${category}-image`).attr('alt', 'No recommendations available');
                    } else {
                        updateOutfitDisplay(category);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Recommendation error:', error);
                console.error('Response:', xhr.responseText);
                try {
                    const response = JSON.parse(xhr.responseText);
                    $('.weather-status').text(response.error || 'Error loading recommendations');
                } catch (e) {
                    $('.weather-status').text('Error loading recommendations');
                }
            }
        });
    }

    // Update recommendations when device changes
    document.addEventListener('deviceChanged', updateOutfitRecommendations);

    // Initial update and regular updates
    $(document).ready(function() {
        updateOutfitRecommendations();
        setInterval(updateOutfitRecommendations, 300000); // Update every 5 minutes
    });
</script>
