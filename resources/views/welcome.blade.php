<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans">
    <div class="absolute top-0 left-0 w-full h-full bg-center bg-repeat bg-[length:34rem]"
        style="background-image: url('{{ asset('assets/bg-pattern.jpg') }}');">
    </div>
    <div class="text-white">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <main class="">
                    <div class="flex flex-col items-center justify-center">
                        <p class="text-3xl font-bold">Bienvenido a las votaciones anuales de
                            <a class="text-purple-500 relative after:bg-purple-500 after:absolute after:h-0.5 after:w-0 after:bottom-0 after:left-0 hover:after:w-full after:transition-all after:duration-300"
                                href="https://www.twitch.tv/protegod">Protegod</a>
                        </p>
                    </div>
                    <div class="flex flex-col items-center justify-center mt-4">
                        <a href="{{ route('oauth.twitch') }}"
                            class="mt-2 text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all duration-300 flex items-center gap-4">
                            <span class="text-2xl font-bold">Continúa con Twitch</span>
                            <img src="{{ asset('assets/glitch_flat_purple.svg') }}" alt="Logo" class="w-8">
                        </a>
                    </div>
                </main>

            </div>
        </div>
    </div>
</body>

</html>
