<div
    class="container relative flex flex-col md:flex-row w-[95%] md:w-fit mx-auto rounded-[25px] shadow-lg backdrop-blur text-white h-auto md:h-[400px]">
    <div class="weather-side relative w-full md:w-[300px] min-h-[300px] rounded-[25px] bg-cover bg-center shadow-lg transition-transform duration-300 hover:scale-110 hover:rotate-y-10 hover:perspective-1500"
        style="background-image: url('https://img.freepik.com/free-photo/sunset-beach-sea-wave_1150-11145.jpg')">
        <div class="absolute inset-0 w-full h-full rounded-[25px] bg-gradient-to-r from-black/40 to-transparent"></div>
        <div class="absolute top-6 left-6">
            <h2 class="text-2xl font-bold m-0">Sunday</h2>
            <span class="block">24 November 2023</span>
            <i class="fa-solid fa-location-dot mt-2"></i>
            <span class="inline-block mt-2">Bandung, ID</span>
        </div>
        <div class="absolute bottom-6 left-6">
            <i class="weather-icon fas fa-cloud-sun fa-3x text-white drop-shadow-md"></i>
            <h1 class="text-6xl font-bold m-0">24°C</h1>
            <h3 class="m-0">Partly Cloudy</h3>
        </div>
    </div>

    <div class="info-side w-full md:w-[400px] p-4">
        <div class="w-full h-full">
            <div class="space-y-2 p-2">
                <div
                    class="humidity bg-slate-200/80 rounded-lg p-3 flex justify-between items-center hover:bg-neutral-400/30 transition-all duration-200 hover:translate-x-1">
                    <span class="font-semibold text-sm text-neutral-800"><i class="fa-solid fa-droplet mr-2"></i>
                        HUMIDITY</span>
                    <span class="font-bold text-neutral-800">78%</span>
                </div>
                <div
                    class="wind bg-slate-200/80 rounded-lg p-3 flex justify-between items-center hover:bg-neutral-400/30 transition-all duration-200 hover:translate-x-1">
                    <span class="font-semibold text-sm text-neutral-800"><i class="fa-solid fa-wind mr-2"></i>
                        WIND</span>
                    <span class="font-bold text-neutral-800">5 km/h</span>
                </div>
                <div
                    class="pressure bg-slate-200/80 rounded-lg p-3 flex justify-between items-center hover:bg-neutral-400/30 transition-all duration-200 hover:translate-x-1">
                    <span class="font-semibold text-sm text-neutral-800"><i class="fa-solid fa-gauge mr-2"></i>
                        PRESSURE</span>
                    <span class="font-bold text-neutral-800">1015 hPa</span>
                </div>
                <div
                    class="altitude bg-slate-200/80 rounded-lg p-3 flex justify-between items-center hover:bg-neutral-400/30 transition-all duration-200 hover:translate-x-1">
                    <span class="font-semibold text-sm text-neutral-800"><i class="fa-solid fa-mountain mr-2"></i>
                        ALTITUDE</span>
                    <span class="font-bold text-neutral-800">25 m</span>
                </div>
                <div
                    class="rain bg-slate-200/80 rounded-lg p-3 flex justify-between items-center hover:bg-neutral-400/30 transition-all duration-200 hover:translate-x-1">
                    <span class="font-semibold text-sm text-neutral-800"><i class="fa-solid fa-cloud-rain mr-2"></i>
                        RAIN INTENSITY</span>
                    <span class="font-bold text-neutral-800">10 mm</span>
                </div>
                <div
                    class="uv bg-slate-200/80 rounded-lg p-3 flex justify-between items-center hover:bg-neutral-400/30 transition-all duration-200 hover:translate-x-1">
                    <span class="font-semibold text-sm text-neutral-800"><i class="fa-solid fa-sun mr-2"></i> UV
                        INDEX</span>
                    <span class="font-bold text-neutral-800">6.2</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    function updateWeatherData() {
        $.ajax({
            url: '{{ route('weather.data') }}',
            method: 'GET',
            success: function(data) {
                console.log('Received data:', data); // Debug log

                if (data.error) {
                    console.error('Error:', data.error);
                    return;
                }

                // Update weather info
                $('.weather-side h1').text(`${data.temperature}°C`);

                // Update sensor values
                $('.humidity .font-bold').text(`${data.humidity}%`);
                $('.wind .font-bold').text(`${data.wind_speed} km/h`);
                $('.pressure .font-bold').text(`${data.pressure} hPa`);
                $('.altitude .font-bold').text(`${data.altitude} m`);
                $('.rain .font-bold').text(`${data.rain_intensity} mm`);
                $('.uv .font-bold').text(data.uv_index);

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
            }
        });
    }

    // Update every 5 seconds
    $(document).ready(function() {
        updateWeatherData(); // Initial load
        setInterval(updateWeatherData, 5000); // Regular updates

        // Log to verify the script is running
        console.log('Weather update script initialized');
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
