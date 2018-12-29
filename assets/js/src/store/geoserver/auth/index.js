import getters from './getters';
import mutations from './mutations';
export const state = {
    guestToken: {
        roles: ['ROLE_GUEST']
    },
    token: {}
};

export default {
    namespaced: true,
    state,
    getters,
    mutations
};