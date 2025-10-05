<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Update Vite CSS --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    {{-- Agar frontend/style.css abhi bhi chahiye to rakh sakte ho --}}
    <link href="{{ asset('frontend/style.css') }}" rel="stylesheet"/>
    
    <title>Document</title>
</head>
<body>
    <div id="app"></div>
</body>
</html>
