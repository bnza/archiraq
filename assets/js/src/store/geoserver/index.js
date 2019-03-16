import mutations from './mutations';

import auth from './auth';

export const state = {
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
