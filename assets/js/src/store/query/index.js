import mutations from './mutations';
import getters from './getters';
import {QUERY_TYPENAME_VW_SITES} from '@/utils/cids';

export const defaultPagination =  {
    page: 1,
    rowsPerPage: 25,
    sortBy: 'id',
    descending: false
};

export const state = {
    [QUERY_TYPENAME_VW_SITES]: {
        pagination: defaultPagination,
        filter: {},
        conditions: {}
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    getters,
};
