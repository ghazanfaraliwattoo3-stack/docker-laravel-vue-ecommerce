<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Laravel Vite CSS --}}
    @vite('resources/css/app.css')

    {{-- Apka extra CSS --}}
    <link href="{{ asset('frontend/style.css') }}" rel="stylesheet"/>

    {{-- Production build CSS (for render) --}}
    <link rel="stylesheet" href="/build/assets/app.css">

    <title>Document</title>
</head>
<body>
    <div id="app"></div>

    {{-- Laravel Vite JS --}}
    @vite('resources/js/app.js')

    {{-- Production build JS (for render) --}}
    <script src="/build/assets/app-X79I1gIu.js"></script>
</body>
</html>
