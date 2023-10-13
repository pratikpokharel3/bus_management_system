<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="flex min-h-screen flex-col bg-gray-100">
        @include('layouts.navigation')

        <x-show_toast></x-show_toast>

        <main class="flex grow gap-x-10 pr-10">
            <x-side-navigation></x-side-navigation>

            <div class="grow py-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>
