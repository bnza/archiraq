import getters from './getters';
import mutations from './mutations';

import auth from './auth';
export const state = {
    baseUrl: ''
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    modules: {
        auth: auth
    }
};