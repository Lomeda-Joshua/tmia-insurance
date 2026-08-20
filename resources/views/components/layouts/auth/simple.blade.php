<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <!-- Customized Style -->
        <link rel="stylesheet" type="text/css" href="{{ asset('tmia-assets/assets/css/home.css') }}">
    </head>
<body>
    {{ $slot }}    
</body>

</html>
