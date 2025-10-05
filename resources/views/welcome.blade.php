<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Laravel Vite CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Apka extra CSS --}}
    <link href="{{ asset('frontend/style.css') }}" rel="stylesheet"/>

    <title>Document</title>
</head>
<body>
    <div id="app"></div>
</body>
</html>
