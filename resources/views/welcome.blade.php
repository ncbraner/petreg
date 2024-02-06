<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pet Registration</title>
        <!-- Include Tailwind CSS from CDN -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite('resources/js/app.js')
        <style>
            .paw::before {
                content: "🐾";
                display: inline-block;
                margin-right: 4px;
                font-size: 4rem;

            }
        </style>
    </head>
    <body class="antialiased">
    <div id="app">
        <header class="w-full p-4 bg-blue-700 text-white text-center text-2xl font-bold block" >
            Pet Registration
        </header>
        <nav-bar></nav-bar>
        <router-link to="/"></router-link>
        <router-link to="/list"></router-link>
        <router-view></router-view>
    </div>
    <footer class="w-full p-4 bg-blue-700 text-white text-center text-2xl font-bold">
        2024 Paw Inc.
    </footer>
    </body>
</html>
