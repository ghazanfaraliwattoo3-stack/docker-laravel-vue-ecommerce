<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Vue</title>
    @vite(['resources/js/app.js']) <!-- CSS imported inside app.js -->
    <link href="{{ asset('frontend/style.css') }}" rel="stylesheet"/>

</head>
<body>
    <div id="app"></div>
</body>
</html>
