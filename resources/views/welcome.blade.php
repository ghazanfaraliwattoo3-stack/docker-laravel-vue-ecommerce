<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Vue Laravel App</title>

    {{-- Vite CSS + JS ek hi call me --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    {{-- Extra frontend CSS agar chahiye --}}
    <link href="{{ asset('frontend/style.css') }}" rel="stylesheet"/>
</head>
<body>
    <div id="app"></div>
</body>
</html>
