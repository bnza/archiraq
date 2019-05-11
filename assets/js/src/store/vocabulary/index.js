import mutations from '@/store/vocabulary/mutations';
import actions from '@/store/vocabulary/actions';

export const state = {
    districts: [],
    chronologies: []
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
