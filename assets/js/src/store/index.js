import Vue from 'vue';
import Vuex from 'vuex';
import actions from './actions';
import mutations from './mutations';
import client from './client';
import components from './components';
import geoserver from './geoserver';
import query from './query';

Vue.use(Vuex);

const options = {
    state: {
        bingApiKey: '',
    },
    mutations,
    actions,
    modules: {
        client: client,
        components: components,
        geoserver: geoserver,
        query: query,
    }
};

export default new Vuex.Store(options);
