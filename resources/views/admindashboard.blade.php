<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body>
    <div class="flex min-h-screen">
        <x-adminsidebar />

        <div class="flex-1">
            <div class="flex items-center justify-center min-h-screen">
                <main class="w-full px-8">
                    @if ($component === 'adminusermanagement')
                        <x-adminusermanagement :users="$users" />
                    @elseif ($component === 'admindevicemanagement')
                        <x-admindevicemanagement :devices="$devices" />
                    @elseif ($component === 'admindashboard')
                        <x-admindashboard :userCount="$userCount" :deviceCount="$deviceCount" />
                    @elseif ($component === 'adminmanageblog')
                        <x-adminmanageblog :posts="$posts" />
                    @endif
                </main>
            </div>
        </div>
    </div>

    <div
        class="absolute top-20 left-0 md:left-2 w-[250px] h-[250px] md:w-[500px] md:h-[500px] bg-[#20D1C880] rounded-full mix-blend-multiply filter blur-[80px] md:blur-[150px] opacity-70 animate-blob z-[-99]">
    </div>
    <div
        class="absolute top-20 right-0 md:right-32 w-[250px] h-[250px] md:w-[500px] md:h-[500px] bg-[#2096FF80] rounded-full mix-blend-multiply filter blur-[80px] md:blur-[150px] opacity-70 animate-blob animation-delay-2000 z-[-99]">
    </div>
    <div
        class="hidden md:block absolute bottom-10 left-32 w-[500px] h-[500px] bg-[#20FFD180] rounded-full mix-blend-multiply filter blur-[150px] opacity-70 animate-blob animation-delay-4000 z-[-99]">
    </div>
</body>

</html>
