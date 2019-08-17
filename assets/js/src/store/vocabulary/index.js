import mutations from '@/store/vocabulary/mutations';
import actions from '@/store/vocabulary/actions';
import getters from '@/store/vocabulary/getters';

export const state = {
    districts: [],
    chronologies: []
};

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
};
