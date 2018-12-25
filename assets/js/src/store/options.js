/* global process */

import mutations from './mutations';
import components from './components';

export const state = {
    bingApiKey: '',
    default: {
        baseMap: 'bing',
        bingImagerySet: 'AerialWithLabels'
    }
};

export const getters = {};

export const options = {
    strict: process.env.NODE_ENV !== 'production',
    state,
    mutations,
    getters,
    modules: {
        components: components
    }
};

export default options;