/**
 * @file Manages HTTP query string
 * @author Pietro Baldassarri
 */

import qs from 'qs';

const LIMIT = 25;

/**
 *
 * @param {Object} pagination The Vuetify DataTable pagination object
 * @returns {number}
 */
const getPaginationLimit = (pagination) => {
    return pagination.rowsPerPage || LIMIT;
};

/**
 *
 * @param {Object} pagination The Vuetify DataTable pagination object
 * @returns {number}
 */
const getPaginationOffset = (pagination) => {
    return pagination.rowsPerPage * (pagination.page - 1);
};

/**
 * Converts Vuetify pagination query object to an object which will be stringified by qs
 *
 * @see https://vuetifyjs.com/en/components/data-tables#paginate-and-sort-server-side
 * @param {Object} pagination The Vuetify DataTable pagination object
 * @returns {{offset: {number}, limit: {number}, sort: {object}}} The pagination query object
 */
export const convertPaginationQueryFragment = (pagination) => {
    const _query = {
        limit: getPaginationLimit(pagination),
        offset: getPaginationOffset(pagination),
    };
    if (pagination.sortBy) {
        _query.sort = {
            [pagination.sortBy]: pagination.descending ? 'DESC' : 'ASC'
        };
    }
    return _query;
};

/**
 *
 * @param {Object} query The VueRouter qs parsed query
 * @return {string|*}
 */
export const getHttpQueryString = (query) => {
    const _query = {
        pagination: convertPaginationQueryFragment(query.pagination)
    };
    return qs.stringify(_query);
};
