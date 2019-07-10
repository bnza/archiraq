import getters from './getters';
import mutations from './mutations';
import {ROLE_GUEST} from '@/store/auth';

export const state = {
    guestToken: {
        roles: [ROLE_GUEST]
    },
    token: {}
};

export default {
    namespaced: true,
    state,
    getters,
    mutations
};
