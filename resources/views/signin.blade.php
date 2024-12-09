<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body>
    <div class="relative min-h-screen bg-gray-50" id="background">
        <!-- Form Display -->
        <div class="relative z-50 max-h-screen overflow-y-auto py-6">
            <x-dynamic-component :component="$form" />
        </div>

        <!-- Background Blobs -->
        <div
            class="absolute top-20 left-0 md:left-2 w-[250px] h-[250px] md:w-[500px] md:h-[500px] bg-[#20D1C880] 
    rounded-full mix-blend-multiply filter blur-[80px] md:blur-[150px] opacity-70 animate-blob z-10">
        </div>

        <div
            class="absolute top-20 right-0 md:right-32 w-[250px] h-[250px] md:w-[500px] md:h-[500px] bg-[#2096FF80] 
    rounded-full mix-blend-multiply filter blur-[80px] md:blur-[150px] opacity-70 animate-blob animation-delay-2000 z-10">
        </div>

        <div
            class="hidden md:block absolute bottom-10 left-32 w-[500px] h-[500px] bg-[#20FFD180] 
    rounded-full mix-blend-multiply filter blur-[150px] opacity-70 animate-blob animation-delay-4000 z-10">
        </div>

        <div
            class="absolute bottom-0 md:bottom-10 right-0 md:right-52 w-[250px] h-[250px] md:w-[500px] md:h-[500px] 
    bg-[#80EEF580] rounded-full mix-blend-multiply filter blur-[80px] md:blur-[150px] opacity-70 animate-blob 
    animation-delay-4000 z-10">
        </div>

    </div>
</body>

</html>
