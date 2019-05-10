import Vue from 'vue';
export const SET_PAGINATION = 'setPagination';
export const SET_FILTER = 'setFilter';

export default {
    [SET_PAGINATION](state, {typename, pagination}) {
        Vue.set(state[typename], 'pagination', pagination);
    },
    [SET_FILTER](state, {typename, filter}) {
        Vue.set(state[typename], 'filter', filter);
    },
};
