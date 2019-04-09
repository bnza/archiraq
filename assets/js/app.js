/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import Vue from 'vue';
import Vuetify from 'vuetify';
import store from './src/store';
import router from './src/router';
import { sync } from 'vuex-router-sync';
import VueLayers from 'vuelayers';

import App from './src/App';

/*import 'vuelayers/lib/style.css';
import 'vuetify/dist/vuetify.min.css';*/
import '../css/app.scss';

Vue.use(Vuetify);
Vue.use(VueLayers, {
    dataProjection: 'EPSG:4326',
});

sync(store, router);

window.app = new Vue({
    el: '#app',
    router,
    store,
    components: { App },
    template: '<App/>'
});
