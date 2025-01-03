@php
    $devices = Auth::user()->devices;
@endphp

<div class="w-full mb-4 px-4 flex flex-col justify-center items-center gap-2">
    <select id="deviceSelector" class="form-select rounded-lg bg-slate-200/80 p-2 min-w-[200px]">
        @foreach ($devices as $device)
            <option value="{{ $device->device_id }}" data-user="{{ Auth::id() }}">
                {{ $device->device_name }} ({{ $device->device_id }})
            </option>
        @endforeach
    </select>
    <div id="deviceAlert" class="hidden w-full md:w-[400px] p-4 rounded-lg bg-red-100 text-red-700 text-center">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span class="alert-message"></span>
    </div>
</div>

<div class="flex flex-col md:flex-row gap-4 w-full">
    <div
        class="container relative flex flex-col md:flex-row w-[95%] md:w-fit mx-auto rounded-[25px] shadow-lg backdrop-blur text-white h-auto md:h-[400px]">
        <div class="weather-side relative w-full md:w-[300px] min-h-[300px] rounded-[25px] bg-cover bg-center shadow-lg transition-transform duration-300 hover:scale-110 hover:rotate-y-10 hover:perspective-1500"
            style="background-image: url('https://img.freepik.com/free-photo/sunset-beach-sea-wave_1150-11145.jpg')">
            <div class="absolute inset-0 w-full h-full rounded-[25px] bg-gradient-to-r from-black/40 to-transparent">
            </div>
            <div class="absolute top-6 left-6">
                <h2 class="text-2xl font-bold m-0"> </h2>
                <span class="block"> </span>
                <i class="fa-solid fa-location-dot mt-2"></i>
                <span class="inline-block mt-2">Bandung, ID</span>
            </div>
            <div class="absolute bottom-6 left-6">
                <i class="weather-icon fas  fa-3x text-white drop-shadow-md"></i>
                <h1 class="text-6xl font-bold m-0"> </h1>
                <h3 class="m-0"> </h3>
            </div>
        </div>

        <div class="info-side w-full md:w-[400px] p-4">
            <div class="w-full h-full">
                <div class="space-y-2 p-2">
                    <div
                        class="humidity bg-slate-200/80 rounded-lg p-3 flex justify-between items-center hover:bg-neutral-400/30 transition-all duration-200 hover:translate-x-1">
                        <span class="font-semibold text-sm text-neutral-800"><i class="fa-solid fa-droplet mr-2"></i>
                            HUMIDITY</span>
                        <span class="font-bold text-neutral-800"> </span>
                    </div>
                    <div
                        class="wind bg-slate-200/80 rounded-lg p-3 flex justify-between items-center hover:bg-neutral-400/30 transition-all duration-200 hover:translate-x-1">
                        <span class="font-semibold text-sm text-neutral-800"><i class="fa-solid fa-wind mr-2"></i>
                            WIND</span>
                        <span class="font-bold text-neutral-800"> </span>
                    </div>
                    <div
                        class="pressure bg-slate-200/80 rounded-lg p-3 flex justify-between items-center hover:bg-neutral-400/30 transition-all duration-200 hover:translate-x-1">
                        <span class="font-semibold text-sm text-neutral-800"><i class="fa-solid fa-gauge mr-2"></i>
                            PRESSURE</span>
                        <span class="font-bold text-neutral-800"> </span>
                    </div>
                    <div
                        class="altitude bg-slate-200/80 rounded-lg p-3 flex justify-between items-center hover:bg-neutral-400/30 transition-all duration-200 hover:translate-x-1">
                        <span class="font-semibold text-sm text-neutral-800"><i class="fa-solid fa-mountain mr-2"></i>
                            ALTITUDE</span>
                        <span class="font-bold text-neutral-800"> </span>
                    </div>
                    <div
                        class="rain bg-slate-200/80 rounded-lg p-3 flex justify-between items-center hover:bg-neutral-400/30 transition-all duration-200 hover:translate-x-1">
                        <span class="font-semibold text-sm text-neutral-800"><i class="fa-solid fa-cloud-rain mr-2"></i>
                            RAIN INTENSITY</span>
                        <span class="font-bold text-neutral-800"> </span>
                    </div>
                    <div
                        class="uv bg-slate-200/80 rounded-lg p-3 flex justify-between items-center hover:bg-neutral-400/30 transition-all duration-200 hover:translate-x-1">
                        <span class="font-semibold text-sm text-neutral-800"><i class="fa-solid fa-sun mr-2"></i> UV
                            INDEX</span>
                        <span class="font-bold text-neutral-800"> </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div
    class="container relative flex flex-col w-[95%] md:w-[400px] mx-auto mt-4 rounded-[25px] shadow-md backdrop-blur text-neutral-800 h-auto">
    <div class="relative w-full min-h-[120px] rounded-[25px] bg-cover bg-center"
        style="background-image: url('https://img.freepik.com/free-photo/rain-drops-glass-window-with-cloudy-sky-background_632805-57.jpg')">
        <div class="absolute inset-0 w-full h-full rounded-[25px] bg-gradient-to-b from-transparent to-slate-400/90">
        </div>
        <div class="relative z-10 p-3">
            <div class="bg-white/60 rounded-xl p-3 backdrop-blur-sm text-center">
                <h2 class="text-xl font-bold mb-2">Rain Prediction</h2>
                <div class="flex flex-col items-center justify-center">
                    <div class="flex items-center gap-2">
                        <div class="prediction-status text-2xl font-bold">Unknown</div>
                        <i class="prediction-icon fas fa-question fa-lg"></i>
                    </div>
                    <div class="prediction-certainty text-sm text-neutral-600">(0% certainty)</div>
                    <div class="prediction-time text-xs text-neutral-500 mt-1">Last updated: <span>-</span></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    function getWeatherIcon(condition) {
        // Map weather conditions to Font Awesome icons
        const iconMap = {
            'Clear': 'fa-sun',
            'Cloudy': 'fa-cloud',
            'Light Rain': 'fa-cloud-rain',
            'Moderate Rain': 'fa-cloud-showers-heavy',
            'Heavy Rain': 'fa-cloud-showers-heavy',
            'Hot': 'fa-temperature-high',
            'Windy': 'fa-wind',
            'Unknown': 'fa-question'
        };
        return iconMap[condition] || iconMap['Unknown'];
    }

    function getRainPredictionIcon(prediction) {
        const iconMap = {
            'Rain': 'fa-cloud-showers-heavy',
            'Light Rain': 'fa-cloud-rain',
            'Moderate Rain': 'fa-cloud-showers-heavy',
            'Heavy Rain': 'fa-cloud-showers-heavy',
            'No Rain': 'fa-sun',
            'Unknown': 'fa-question'
        };
        return iconMap[prediction] || iconMap['Unknown'];
    }

    function showDeviceAlert(message) {
        $('#deviceAlert').removeClass('hidden').find('.alert-message').text(message);
    }

    function hideDeviceAlert() {
        $('#deviceAlert').addClass('hidden');
    }

    function updateWeatherData() {
        const selectedDevice = $('#deviceSelector').val();
        const userId = $('#deviceSelector option:selected').data('user');

        $.ajax({
            url: '{{ route('weather.data') }}',
            method: 'GET',
            data: {
                device_id: selectedDevice,
                user_id: userId
            },
            success: function(data) {
                hideDeviceAlert();
                if (data.error) {
                    showDeviceAlert(data.error);
                    return;
                }

                // Update weather info
                $('.weather-side h1').text(`${data.temperature}°C`);
                $('.weather-side h3').text(data.weather_condition);

                // Update weather icon
                const iconClass = getWeatherIcon(data.weather_condition);
                $('.weather-icon').removeClass().addClass(
                    `weather-icon fas ${iconClass} fa-3x text-white drop-shadow-md`);

                // Update sensor values
                $('.humidity .font-bold').text(`${data.humidity}%`);
                $('.wind .font-bold').text(`${data.wind_speed} km/h`);
                $('.pressure .font-bold').text(`${data.pressure} hPa`);
                $('.altitude .font-bold').text(`${data.altitude} m`);
                $('.rain .font-bold').text(`${data.rain_intensity} mm`);
                $('.uv .font-bold').text(data.uv_index);

                // Update rain prediction
                $('.rain-prediction .prediction-text').text(data.rain_prediction);
                $('.rain-prediction .certainty-text').text(
                    `(${(data.rain_prediction_certainty * 100).toFixed(1)}% certainty)`
                );

                // Update rain prediction in separate container
                $('.prediction-status').text(data.rain_prediction);
                const predictionIconClass = getRainPredictionIcon(data.rain_prediction);
                $('.prediction-icon').removeClass().addClass(
                    `prediction-icon fas ${predictionIconClass} fa-2x`);
                $('.prediction-certainty').text(
                    `(${(data.rain_prediction_certainty * 100).toFixed(1)}% certainty)`
                );
                const formattedTime = new Date(data.timestamp).toLocaleTimeString();
                $('.prediction-time span').text(formattedTime);

                // Update timestamp from server
                const serverDate = new Date(data.timestamp);
                const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                    'September', 'October', 'November', 'December'
                ];

                $('.weather-side h2').text(days[serverDate.getDay()]);
                $('.weather-side span:first').text(
                    `${serverDate.getDate()} ${months[serverDate.getMonth()]} ${serverDate.getFullYear()}`
                );
            },
            error: function(xhr, status, error) {
                console.error('Ajax error:', error);
                console.log('Response:', xhr.responseText);
                const response = JSON.parse(xhr.responseText);
                showDeviceAlert(response.error || 'Error connecting to device');
            }
        });
    }

    // Update every 5 seconds
    $(document).ready(function() {
        function storeDeviceInfo() {
            const deviceId = $('#deviceSelector').val();
            const userId = $('#deviceSelector option:selected').data('user');
            localStorage.setItem('selectedDeviceId', deviceId);
            localStorage.setItem('selectedUserId', userId);

            // Dispatch event
            document.dispatchEvent(new CustomEvent('deviceChanged', {
                detail: {
                    deviceId,
                    userId
                }
            }));
        }

        // Store initial device info
        storeDeviceInfo();

        // Update stored info on change
        $('#deviceSelector').on('change', function() {
            storeDeviceInfo();
            updateWeatherData();
        });

        // Dispatch initial device selection
        const initialDevice = $('#deviceSelector').val();
        const initialUserId = $('#deviceSelector option:selected').data('user');
        document.dispatchEvent(new CustomEvent('deviceChanged', {
            detail: {
                deviceId: initialDevice,
                userId: initialUserId
            }
        }));

        // Device selector change event
        $('#deviceSelector').on('change', function() {
            const selectedDevice = $(this).val();
            const userId = $(this).find('option:selected').data('user');
            document.dispatchEvent(new CustomEvent('deviceChanged', {
                detail: {
                    deviceId: selectedDevice,
                    userId: userId
                }
            }));
        });

        updateWeatherData(); // Initial load
        setInterval(updateWeatherData, 5000); // Regular updates

        // Add change event handler for device selector
        $('#deviceSelector').on('change', function() {
            updateWeatherData();
        });

        // Log to verify the script is running
        console.log('Weather update script initialized');
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
