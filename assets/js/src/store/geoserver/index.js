import mutations from './mutations';

import auth from './auth';

export const state = {
    on: true,
    baseUrl: ''
};

export default {
    namespaced: true,
    state,
    mutations,
    modules: {
        auth: auth
    }
};
