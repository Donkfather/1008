<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{config('app.name')}}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            height: 100vh;
            font-weight: 800;
            margin: 0;
        }
    </style>
    <script>
        window.appState = {}
        window.appState.user = {!! auth()->user()  !!}
    </script>
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <script src="{{mix('js/manifest.js')}}"></script>
</head>
<body class="bg-grey-light pt-5">

<div id="app" class="h-full w-full flex items-center justify-center">
    @yield('content')
</div>


<script src="{{mix('js/vendor.js')}}"></script>
<script src="{{mix('js/app.js')}}"></script>
</body>
</html>
