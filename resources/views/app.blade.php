<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>

        <link rel="icon" type="image/x-icon" href="/favicon.ico">

        <title>Roast</title>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

        <script src="https://webapi.amap.com/maps?v=1.4.8&key=8269d8a1c887cbcbb5b59ec9295a7e89"></script>

    </head>
    <body>

        <div id="app">
            <router-view></router-view>
        </div>

    </body>
</html>