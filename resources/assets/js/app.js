/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue');
import moment from 'moment'

Vue.prototype.moment = moment

import * as VueGoogleMaps from "vue2-google-maps";

Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyALyeHLZteKohX0_FqvaBY3FKZtguPEcY0",
        libraries: "visualization" //necessary for places input
    }
});
Vue.component('google-map', require('./components/GoogleMap'))
import GmapCluster from 'vue2-google-maps/dist/components/cluster' // replace src with dist if you have Babel issues

Vue.component('GmapCluster', GmapCluster)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

import Vuex from 'vuex'
import {mapState} from 'vuex'

Vue.use(Vuex);

let store = new Vuex.Store({
    state: {
        user: null,
        events: [],
        selectedEvent: null
    },
    getters: {

    },
    mutations: {
        addEvents(state, payload) {
            payload.forEach(item => {
                state.events.push(_.extend(item,{locations: []}));
            })
            if(payload.length > 0){
                state.selectedEvent = 0;
            }
        },
        patchEvent(state, payload) {
            let index = _.findIndex(state.events,{id: payload.id})
            if (~index) {
                state.events[index] = Object.assign(state.events[index],payload.event)
            }
        },
        updateUser(state, payload) {
            state.user = payload
        },
        addLocationToEvent(state,payload){
            let index = _.findIndex(state.events,{id: payload.event_id})
            state.events[index].locations.push({lat:payload.lat,lng: payload.lng})
        },
        changeSelectedEvent(state,index){
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
    beforeCreate(){
        this.$store.commit('updateUser', window.appState.user);
    },
    mounted() {
        axios.get('/events').then(response => {
            let events = response.data.events
            this.$store.commit('addEvents', events)
            this.subscribeToEvents();
        })
    },
    methods: {
        subscribeToEvents() {
            this.events.forEach(ev => {
                Echo.channel(`event-${ev.id}`)
                    .listen('NewCheckinLocation',  (location) => {
                        this.$store.commit('addLocationToEvent',location)
                    })
            })

        },
        checkIn(event) {
            axios.post(`/events/${event.id}/checkin`, {
                token: event.user_token.token,
                location: [44, 33]
            })
                .then(response => {
                    let e = response.data.event
                    this.$store.commit('patchEvent', {id: e.id, event: e})
                });
        }
    }
});
