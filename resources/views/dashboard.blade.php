@extends('layouts.app')
@section('content')
    <div class="sm:w-2/3 mx-auto flex align-center justify-center h-full flex-col">
        <div class="text-center">
            <h2 class="mb-4">
                Salut {{ auth()->user()->name }}
            </h2>
        </div>
        <div>
            <div id="map" style="height: 600px;"></div>
            <div class="text-center mt-5">
                <a class="m-3  border-2 border-blue text-blue hover:bg-blue hover:text-white p-2 no-underline"
                   href="/auth/logout">Logout</a>
                <a class="m-3  border-2 border-blue text-blue hover:bg-blue hover:text-white p-2 no-underline" href="#"
                   onclick="clearInterval(randomInterval)">Clear</a>
            </div>
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
                    new MarkerClusterer()
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
                    setTimeout(drop, 1500);
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
                    markerCluster = new MarkerClusterer(map, markers,
                        {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
                }

                function getRandomInRange(from, to, fixed) {
                    return (Math.random() * (to - from) + from).toFixed(fixed) * 1;
                    // .toFixed() returns string, so ' * 1' is a trick to convert to number
                }
            </script>

            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALyeHLZteKohX0_FqvaBY3FKZtguPEcY0&callback=initMap">
            </script>
            <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        </div>
@endsection