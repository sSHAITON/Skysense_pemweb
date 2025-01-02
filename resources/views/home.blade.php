<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SKYSense</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body>

    <x-navbar />

    <!-- Hero Section -->
    <section id="home">
        <div class="relative px-6 pt-8 lg:px-8">
            <div class="absolute inset-x-0 -top-40 -z-[1] transform-gpu overflow-hidden blur-3xl sm:-top-80"
                aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[48.125rem] -translate-x-1/2 rotate-[40deg] bg-gradient-to-tr from-blue-300 via-teal-300 to-indigo-600 opacity-40 sm:left-[calc(50%-30rem)] sm:w-[96.1875rem]"
                    style="clip-path: polygon(85.1% 54.1%, 100% 71.6%, 97.5% 16.9%, 75.5% 0.1%, 60.7% 12%, 82.5% 42.5%, 50.2% 52.4%, 42.4% 78.1%, 37.5% 48.3%, 25.2% 44.5%, 17.5% 86.7%, 0.1% 54.9%, 27.9% 100%, 47.6% 66.8%, 96.1% 87.7%, 85.1% 54.1%)">
                </div>
            </div>
            <div class="mx-auto max-w-2xl py-8 sm:py-16 lg:py-24">
                <div class="text-center">
                    <h1 class="text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Your
                        Gateway to
                        Real-Time Weather Insights</h1>
                    <p class="mt-8 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">
                        Monitor, analyze, and understand local weather conditions with ease. Powered by cutting-edge IoT
                        technology.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <div class="relative">
                            <div class="absolute -inset-5">
                                <div
                                    class="w-full h-full max-w-sm mx-auto lg:mx-0 opacity-30 blur-lg bg-gradient-to-r from-green-400 via-pink-300 to-teal-300">
                                </div>
                            </div>
                            <a href="/livedata" title=""
                                class="relative z-10 inline-flex items-center justify-center w-full px-8 py-3 text-md font-bold text-white transition-all duration-200 bg-blue-500 border-2 border-transparent sm:w-auto rounded-full font-pj hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900"
                                role="button">
                                View Live Data
                            </a>
                        </div>
                        <a href="#features" class="text-sm/6 font-semibold text-gray-700 hover:text-neutral-900">
                            Learn More <span aria-hidden="true">→</span>
                        </a>
                    </div>
                    <div class="mt-16">
                        <img src="/img/weatherstation.png" alt="Weather Station Visualization"
                            class="mx-auto w-full max-w-md rounded-lg shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Card Features --}}
    <section id="features" class="bg-gradient-to-b from-white to-blue-100 py-12">
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
            aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-blue-300 via-sky-400 to-indigo-600 opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900">Why Choose Our Weather Station?</h2>
                <p class="mt-4 text-lg text-gray-600">Experience the most advanced weather monitoring system available.
                </p>
            </div>
            <div class="mt-10 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                <div class="text-center">
                    <div class="mx-auto mb-4 h-12 w-12 rounded-full bg-sky-100 flex items-center justify-center">
                        🌦️
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Real-Time Data</h3>
                    <p class="mt-2 text-sm text-gray-600">Get live updates on temperature, humidity, wind speed, and
                        more.</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto mb-4 h-12 w-12 rounded-full bg-sky-100 flex items-center justify-center">
                        📊
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Analytics</h3>
                    <p class="mt-2 text-sm text-gray-600">Visualize and analyze historical weather patterns
                        effortlessly.</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto mb-4 h-12 w-12 rounded-full bg-sky-100 flex items-center justify-center">
                        🌍
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Global Connectivity</h3>
                    <p class="mt-2 text-sm text-gray-600">Access data remotely from anywhere in the world.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Live Weather --}}
    <section class="bg-gradient-to-b from-blue-100 to-green-100 py-12">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-900">Live Weather Data</h2>
            <div class="mt-8 shadow-md">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Current Conditions</h3>
                    <p class="text-sm text-gray-600">Location: <span class="font-semibold">Bandung</span></p>
                    <div class="mt-4 flex justify-center gap-8" x-data="weatherData()">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900" x-text="temperature + '°C'">--</p>
                            <p class="text-sm text-gray-600">Temperature</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900" x-text="humidity + '%'">--</p>
                            <p class="text-sm text-gray-600">Humidity</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900" x-text="windSpeed + ' km/h'">--</p>
                            <p class="text-sm text-gray-600">Wind Speed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function weatherData() {
            return {
                temperature: '--',
                humidity: '--',
                windSpeed: '--',
                init() {
                    this.fetchWeatherData();
                    setInterval(() => this.fetchWeatherData(), 30000);
                },
                async fetchWeatherData() {
                    try {
                        const response = await fetch('/public-weather-data');
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        const data = await response.json();
                        this.temperature = data.temperature;
                        this.humidity = data.humidity;
                        this.windSpeed = data.wind_speed;
                    } catch (error) {
                        console.error('Error fetching weather data:', error);
                    }
                }
            }
        }
    </script>

    {{-- About Project --}}
    <section class="bg-gradient-to-b from-green-100 to-white py-12">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="lg:flex lg:items-center lg:gap-10">
                <div class="lg:w-1/2">
                    <h2 class="text-3xl font-bold text-gray-900">About the Project</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Our IoT Weather Station combines precision sensors and cloud computing to provide accurate and
                        accessible weather data. This project is part of our mission to enhance environmental awareness
                        and aid in climate research.
                    </p>
                    <p class="mt-4 text-lg text-gray-600">
                        Technologies used include IoT devices, real-time databases, and responsive web design to ensure
                        a seamless experience across all platforms.
                    </p>
                </div>
                <div class="lg:w-1/2">
                    <img src="/img/weatherstation.png" alt="Weather Station Prototype" class="rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </section>

    {{-- Testimoni --}}
    <section class="relative bg-gradient-to-b from-white to-indigo-100 py-12 overflow-hidden">
        <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="text-center text-3xl font-bold text-gray-900">What People Are Saying</h2>
            <div class="mt-10 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <p class="text-gray-600">"This weather station has transformed the way we track and plan for the
                        weather. Highly recommended!"</p>
                    <p class="mt-4 text-sm font-bold text-gray-900">- John Doe</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <p class="text-gray-600">"I love how easy it is to access data from anywhere. It's intuitive and
                        precise."</p>
                    <p class="mt-4 text-sm font-bold text-gray-900">- Jane Smith</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <p class="text-gray-600">"A fantastic tool for anyone interested in weather data. Great for
                        research!"</p>
                    <p class="mt-4 text-sm font-bold text-gray-900">- Ali Rahman</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact --}}
    <section class="relative  bg-gradient-to-b from-indigo-100 to-white text-neutral-900 overflow-hidden">
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
            aria-hidden="true">
        </div>
        <div class="relative max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold">Contact Us</h2>
            <p class="mt-4">Have any questions or feedback? Feel free to reach out to us!</p>
            <form action="/submit-form" method="POST"
                class="mt-6 max-w-xl mx-auto space-y-4 border border-gray-200 rounded-lg p-6 bg-white shadow-md">
                <div>
                    <label for="name" class="block text-sm font-medium text-neutral-900 text-left">Name</label>
                    <input type="text" id="name" name="name" placeholder="Your Name"
                        class="w-full mt-2 p-2 rounded-md border border-gray-300 focus:ring-2 " required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-neutral-900 text-left">Email</label>
                    <input type="email" id="email" name="email" placeholder="Your Email"
                        class="w-full mt-2 p-2 rounded-md border border-gray-300 focus:ring-2 " required>
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-neutral-900 text-left">Message</label>
                    <textarea id="message" name="message" rows="4" placeholder="Your Message"
                        class="w-full mt-2 p-2 rounded-md border border-gray-300 focus:ring-2 " required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit"
                        class="bg-white text-blue-400 px-4 py-2 rounded-lg font-bold hover:bg-blue-400 hover:text-white border border-blue-400">Send
                    </button>
                </div>
            </form>
        </div>
    </section>

    <footer>
        <x-footer></x-footer>
    </footer>

</body>

</html>
