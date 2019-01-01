/* global process */

import mutations from './mutations';
import actions from './actions';
import geoserver from './geoserver';
import components from './components';


export const state = {
    bingApiKey: '',
    default: {
        baseMap: 'bing',
        bingImagerySet: 'AerialWithLabels',
        currentLayer: 'archiraq_admbnd2_wfs'
    }
};

export const getters = {};

export const options = {
    strict: process.env.NODE_ENV !== 'production',
    state,
    mutations,
    getters,
    actions,
    modules: {
        components: components,
        geoserver: geoserver
    }
};

export default options;