import mutations from './mutations';
import getters from './getters';

export const defaultPagination =  {
    page: 1,
    rowsPerPage: 25,
    sortBy: 'id',
    descending: false
};

export const state = {
    'vw-site': {
        pagination: defaultPagination,
        filter: {}
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    getters,
};
