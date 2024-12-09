<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300">

</head>

<body>
    <x-navbar />

    <div class="min-h-screeen">
        <x-blogposts />
    </div>

    <div
        class="absolute top-20 left-0 md:left-2 w-[250px] h-[250px] md:w-[500px] md:h-[500px] bg-[#20D1C880] 
    rounded-full mix-blend-multiply filter blur-[80px] md:blur-[150px] opacity-70 animate-blob z-[-99]">
    </div>

    <div
        class="absolute top-20 right-0 md:right-32 w-[250px] h-[250px] md:w-[500px] md:h-[500px] bg-[#2096FF80] 
    rounded-full mix-blend-multiply filter blur-[80px] md:blur-[150px] opacity-70 animate-blob animation-delay-2000 z-[-99]">
    </div>

    <div
        class="hidden md:block absolute bottom-10 left-32 w-[500px] h-[500px] bg-[#20FFD180] 
    rounded-full mix-blend-multiply filter blur-[150px] opacity-70 animate-blob animation-delay-4000 z-[-99]">
    </div>


    <x-footer />

</body>

</html>
