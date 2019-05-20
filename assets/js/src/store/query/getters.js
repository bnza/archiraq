export const GET_CONDITIONS = 'getConditions';
export const GET_FILTER = 'getFilter';
export const GET_PAGINATION = 'getPagination';

export default {
    [GET_CONDITIONS]: (state) => (typename) => {
        return state[typename].conditions;
    },
    [GET_FILTER]: (state) => (typename) => {
        return state[typename].filter;
    },
    [GET_PAGINATION]: (state) => (typename) => {
        return state[typename].pagination;
    }
};
