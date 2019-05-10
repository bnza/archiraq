export const GET_PAGINATION = 'getPagination';
export const GET_FILTER = 'getFilter';

export default {
    [GET_PAGINATION]: (state) => (typename) => {
        return state[typename].pagination;
    },
    [GET_FILTER]: (state) => (typename) => {
        return state[typename].filter;
    }
};
