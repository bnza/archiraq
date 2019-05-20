import Vue from 'vue';
export const SET_CONDITIONS = 'setConditions';
export const SET_FILTER = 'setFilter';
export const SET_PAGINATION = 'setPagination';


export default {
    [SET_CONDITIONS](state, {typename, conditions}) {
        Vue.set(state[typename], 'conditions', conditions);
    },
    [SET_FILTER](state, {typename, filter}) {
        Vue.set(state[typename], 'filter', filter);
    },
    [SET_PAGINATION](state, {typename, pagination}) {
        Vue.set(state[typename], 'pagination', pagination);
    }
};
