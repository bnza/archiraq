import Vue from 'vue';
import Vuex from 'vuex';
import actions from './actions';
import mutations from './mutations';
import components from './components';
import geoserver from './geoserver';

Vue.use(Vuex);

const options = {
    state: {
        bingApiKey: '',
    },
    mutations,
    actions,
    modules: {
        components: components,
        geoserver: geoserver
    }
};

export default new Vuex.Store(options);
