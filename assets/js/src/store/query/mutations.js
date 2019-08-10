import Vue from 'vue';
import {defaultPagination} from '@/store/query/index';

export const ADD_QUERY = 'addQuery';
export const SET_QUERY = 'setQuery';
export const SET_CONDITIONS = 'setConditions';
export const SET_FILTER = 'setFilter';
export const SET_PAGINATION = 'setPagination';

const addQuery = function (state, {typename, query = {}}) {
    if (!query.pagination) {
        query.pagination = defaultPagination;
    }
    Vue.set(state, typename, query);
};

const setQuery = function (state, {typename, key, value}) {
    if (!state.hasOwnProperty(typename)) {
        addQuery(state, {typename, query: {[key]: value}});
    } else {
        Vue.set(state[typename], key, value);
    }
};

export default {
    [ADD_QUERY]: addQuery,
    [SET_QUERY]: setQuery,
    [SET_CONDITIONS](state, {typename, conditions}) {
        setQuery(state, {typename, key: 'conditions', value: conditions});
    },
    [SET_FILTER](state, {typename, filter}) {
        setQuery(state,{typename, key: 'filter', value: filter});
    },
    [SET_PAGINATION](state, {typename, pagination}) {
        setQuery(state, {typename, key: 'pagination', value: pagination});
    }
};
