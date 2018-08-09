/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue');
import moment from 'moment'
import * as VueGoogleMaps from "vue2-google-maps";
import GmapCluster from 'vue2-google-maps/dist/components/cluster' // replace src with dist if you have Babel issues
import Vuex, {mapState} from 'vuex'
import Snotify, {SnotifyPosition} from 'vue-snotify';

Vue.use(Snotify, {
    toast: {
        position: SnotifyPosition.rightTop
    }
});

Vue.prototype.moment = moment

Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyALyeHLZteKohX0_FqvaBY3FKZtguPEcY0",
        libraries: "visualization" //necessary for places input
    }
});
Vue.component('google-map', require('./components/GoogleMap'))


Vue.component('GmapCluster', GmapCluster)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.use(Vuex);

let store = new Vuex.Store({
    state: {
        user: null,
        events: [],
        selectedEvent: null
    },
    mutations: {
        addEvents(state, payload) {
            payload.forEach(item => {
                state.events.push(_.extend(item, {locations: []}));
            })
            if (payload.length > 0) {
                state.selectedEvent = 0;
            }
        },
        patchEvent(state, payload) {
            let index = _.findIndex(state.events, {id: payload.id})
            if (~index) {
                state.events[index] = Object.assign(state.events[index], payload.event)
            }
        },
        updateUser(state, payload) {
            state.user = payload
        },
        addLocationToEvent(state, payload) {
            let index = _.findIndex(state.events, {id: payload.event_id})
            state.events[index].locations.push({lat: payload.lat, lng: payload.lng})
        },
        changeSelectedEvent(state, index) {
            state.selectedEvent = index;
        }
    }
})

const app = new Vue({
    el: '#app',
    store,
    computed: mapState({
        events: state => state.events,
        user: state => state.user,
        selectedEvent: state => state.selectedEvent
    }),
    created() {
        this.$store.commit('updateUser', window.appState.user);
    },
    mounted() {
        if (this.user) {
            axios.get('/events').then(response => {
                let events = response.data.events
                this.$store.commit('addEvents', events)
                this.subscribeToEvents();
            })
        }

    },
    methods: {
        subscribeToEvents() {

        },
        checkIn(event) {
            if (navigator.geolocation && this.user) {
                navigator.geolocation.getCurrentPosition(position => {
                    axios.post(`/events/${event.id}/checkin`, {
                        location: {
                            lat: position.coords.latitude + (Math.floor(Math.random() * 999) + 111) / 10 ** 6,
                            lng: position.coords.longitude + (Math.floor(Math.random() * 999) + 111) / 10 ** 6
                        },
                    })
                        .then(response => {
                            let e = response.data.event
                            this.$store.commit('patchEvent', {id: e.id, event: e})
                            this.$snotify.success('Locatia a fost trimisa cu succes.');
                        });
                }, error => {
                    this.$snotify.warning('A aparut o eroare. Trebuie sa permiti accesul la locatie.')
                })
            } else {
                this.$snotify.error('Deviceul tau nu suporta functia de locatie. Scuze :(')
            }

        }
    }
});
