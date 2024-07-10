<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link rel="stylesheet" href="{{ asset('css/utilities.css') }}">
    {{ $style }}


    <link rel="shortcut icon" href="{{ asset('img/da.png') }}" />
    <title>Dekor Apps</title>

    <script src="{{ asset('js/utilities.js') }}" defer></script>
    {{ $js ?? '' }}
</head>

<body class="m-0">

    @include('components.header')

    {{-- main contents --}}
    {{ $slot }}
    {{-- main contents --}}
    <footer>
        <div class="site-info">
        <h2 style="color:white;">Dekor Apps</h2>
            <p>est 2024</p>
        </div>
    </footer>
</body>

</html>
