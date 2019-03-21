import actions from './actions';
import getters from './getters';
import mutations from './mutations';

export const state = {
    all: [],
    pending: []
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
