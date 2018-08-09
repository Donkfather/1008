<template>
    <div>
        <br>
        <gmap-map
                ref="mapRef"
                :center="center"
                :zoom="zoom"
                :options="mapStyles"
                style="width:100%;  height: 400px;"
        >
            <gmap-cluster :zoom-on-click="true">
                <gmap-marker
                        :key="index"
                        :animation="2"
                        v-for="(m, index) in markers"
                        :position="m.position"
                        :icon="m.icon"
                        @click="center=m.position"
                ></gmap-marker>
            </gmap-cluster>
        </gmap-map>
    </div>
</template>

<script>
    import {gmapApi} from 'vue2-google-maps'
    import {mapState} from 'vuex'

    let mapStyle = [
        {
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#1d2c4d"
                }
            ]
        },
        {
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#8ec3b9"
                }
            ]
        },
        {
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#1a3646"
                }
            ]
        },
        {
            "featureType": "administrative.country",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#4b6878"
                }
            ]
        },
        {
            "featureType": "administrative.land_parcel",
            "elementType": "labels",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#64779e"
                }
            ]
        },
        {
            "featureType": "administrative.province",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#4b6878"
                }
            ]
        },
        {
            "featureType": "landscape.man_made",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#334e87"
                }
            ]
        },
        {
            "featureType": "landscape.natural",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#023e58"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#283d6a"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#6f9ba5"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#1d2c4d"
                }
            ]
        },
        {
            "featureType": "poi.business",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#023e58"
                }
            ]
        },
        {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#3C7680"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#304a7d"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#98a5be"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#1d2c4d"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#2c6675"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#255763"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#b0d5ce"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#023e58"
                }
            ]
        },
        {
            "featureType": "road.local",
            "elementType": "labels",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "transit",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "transit",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#98a5be"
                }
            ]
        },
        {
            "featureType": "transit",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#1d2c4d"
                }
            ]
        },
        {
            "featureType": "transit.line",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#283d6a"
                }
            ]
        },
        {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#3a4762"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#0e1626"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#4e6d70"
                }
            ]
        }
    ];
    let google = false;
    let pointArray = null;

    export default {
        name: "GoogleMap",
        data() {
            return {
                center: {lat: 44.452861, lng: 26.085829},
                zoom: 10,
                mapStyles: {styles: mapStyle},
                cluster_styles: [
                    {
                        url: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',
                        height: 53,
                        width: 53,
                        textColor: '#FFFFFF',
                        textSize: 14
                    }
                ],
                markers: [],
                points: [],
                heatmap: null,
                loadedGoogle: false,
            };
        },
        computed: {
            google: gmapApi,
            ...mapState({
                event: state => state.events[state.selectedEvent]
            }),
        },
        created() {
            axios.get('/points').then(response => {
                this.points = response.data
            });
        },
        watch: {
            google(g) {
                if (g && !this.loadedGoogle) {
                    this.loadedGoogle = true
                    google = g
                }
            },
            loadedGoogle(val) {
                if (val) {
                    console.log(google.maps)
                    this.reloadMap()
                }
            },
            event(ev, old) {
                if (this.loadedGoogle && ev) {
                    this.reloadMap()
                }
            }
        },
        methods: {
            getPoints() {
                return this.points[(this.event && this.event.hasOwnProperty('id')) ? this.event.id : 0]
            },
            reloadMap() {
                if (pointArray) {
                    pointArray.clear()
                    this.markers = [];
                }
                pointArray = new google.maps.MVCArray([]);
                this.heatmap = new google.maps.visualization.HeatmapLayer({
                    data: pointArray,
                });
                if (this.$refs.mapRef.mapObject) {
                    this.heatmap.setMap(this.$refs.mapRef.mapObject);
                } else {
                    this.$refs.mapRef.$mapPromise.then(map => {
                        this.heatmap.setMap(map);
                    })
                }
                let points = this.getPoints()
                if (points) {
                    points.forEach(item => {
                        this.addMarker(item)
                    })
                }

            },
            addMarker(coords) {
                const marker = {
                    position: {
                        lat: coords.lat,
                        lng: coords.lng
                    },
                    icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'
                };
                this.markers.push(marker);
                pointArray.push(new google.maps.LatLng(marker.position));
            },
        }
    };
</script>