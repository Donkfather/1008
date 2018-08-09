<template>
    <div>
        <br>
        <gmap-map
                ref="mapRef"
                :center="center"
                :zoom="zoom"
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

    let google = false;
    let pointArray = null;

    export default {
        name: "GoogleMap",
        data() {
            return {
                center: {lat: 44.452861, lng: 26.085829},
                zoom: 10,
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
                if(this.loadedGoogle){
                    console.log(ev);
                    this.reloadMap()
                }
            }
        },
        methods: {
            getPoints() {
                return this.points[(this.event && this.event.hasOwnProperty('id'))?this.event.id:0]
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
                this.getPoints().forEach(item => {
                    this.addMarker(item)
                })

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