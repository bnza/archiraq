import Vue from 'vue';
export const SET_PAGINATION = 'getPagination';

export default {
    [SET_PAGINATION](state, {typename, pagination}) {
        Vue.set(state[typename], 'pagination', pagination);
    },
};
