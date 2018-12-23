/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.scss in this case)
//require('../css/app.scss');
import '../css/app.scss'
import '../css/app.styl'

import Vue from 'vue'
import Vuetify from 'vuetify'
import store from './src/store'
import router from './src/router'
import { sync } from 'vuex-router-sync'
import VueLayers from 'vuelayers'
import 'vuelayers/lib/style.css' // needs css-loader
import App from './src/App'

import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)
Vue.use(VueLayers, {
    dataProjection: 'EPSG:4326',
})

sync(store, router)

window.app = new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: { App }
})
