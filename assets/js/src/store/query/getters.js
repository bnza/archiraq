export const GET_PAGINATION = 'getPagination';

export default {
    [GET_PAGINATION]: (state) => (typename) => {
        return state[typename].pagination;
    }
};
