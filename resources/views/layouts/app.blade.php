<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 800;
            height: 100%;
            margin: 0;
        }
    </style>
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <script src="{{mix('js/manifest.js')}}"></script>

    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
</head>
<body>

<div id="app">
    @yield('content')
</div>


<script src="{{mix('js/vendor.js')}}"></script>
<script src="{{mix('js/app.js')}}"></script>
<script>
    let map = null
    let markers = []
    let randomInterval = null
    let markerCluster = null

    let neighborhoods = [
        {lat: 44.452661, lng: 26.085629},
        {lat: 44.452761, lng: 26.085729},
        {lat: 44.452861, lng: 26.085829},
        {lat: 44.452961, lng: 26.085929}
    ];

    function drop() {

        markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
        randomInterval = setInterval(
            function () {
                console.log('running interval');
                let lat = getRandomInRange(44.441622, 44.449886, 6);
                let lng = getRandomInRange(26.089490, 26.095368, 6);
                addMarkerWithTimeout(
                    {
                        lat,
                        lng
                    },
                    3000)

            }, 1000);
        for (var i = 0; i < neighborhoods.length; i++) {
            addMarkerWithTimeout(neighborhoods[i], i * 200);
        }
    }

    function addMarkerWithTimeout(position, timeout) {
        console.log('setting position', position)

        let marker = new google.maps.Marker({
            position: position,
            map: map,
            animation: google.maps.Animation.DROP
        });
        markerCluster.addMarker(marker)
        window.setTimeout(function () {
            markers.push(marker)
        }, timeout);
    }

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 44.452861, lng: 26.085829},
            zoom: 17
        });
        setTimeout(drop, 2000);

    }

    function getRandomInRange(from, to, fixed) {
        return (Math.random() * (to - from) + from).toFixed(fixed) * 1;
        // .toFixed() returns string, so ' * 1' is a trick to convert to number
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALyeHLZteKohX0_FqvaBY3FKZtguPEcY0&callback=initMap">
</script>
</body>
</html>
