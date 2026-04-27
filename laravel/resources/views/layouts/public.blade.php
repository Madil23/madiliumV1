<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $page->title ?? 'Madilium' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <style>
            .custom-bg { background-color: {{ $page->background_color ?? '#f3f4f6' }}; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 custom-bg min-h-screen">
        {{ $slot }}
        @livewireScripts
    </body>
</html>
