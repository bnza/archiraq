/**
 * @file Manages SPA route query
 * @author Pietro Baldassarri
 */


import qs from 'qs';

/**
 * @see https://github.com/ljharb/qs
 * @param route The $route component property
 * @returns {Object} The qs parsed object
 */
export const getRouteQueryFromFullPath = (route) => {
    const query = route.fullPath.match(/\?(.*)$/);
    if (query) {
        return qs.parse(query[1]);
    } else {
        return {};
    }
};

/**
 * Returns the route full path using qs library
 * @param {Object} route
 * @return {string} The given route full path
 */
export const getFullPathFromRoute = (route) => {
    return `${route.path}?${qs.stringify(route.query)}`;
}

/**
 * Merges Vuetify DataTable pagination with the given Vue route
 * @param {Object} route
 * @param {Object} pagination
 * @returns {Object} The route object
 */
export const getPaginatedRoute = (route, pagination) => {
    const _route = {
        path: route.path,
        query: getRouteQueryFromFullPath(route)
    };
    _route.query.pagination = pagination;
    return _route;
};

/**
 * Returns the pagination route query property
 * @param {Object} route
 * @return {Object} The pagination query property
 */
export const getPaginationFromRouteQuery = (route) => {
    const query = getRouteQueryFromFullPath(route);
    return query.pagination || {};
}

/**
 * Navigates to the
 * @param {VueRouter} router
 * @param {Object} route The route object
 */
export const navigateToQuery = (router, route) => {
    router.push(getFullPathFromRoute(route));
};

const getMapDataBasePath = (queryTypename) => {
    return `/map/data/${queryTypename}`;
};

const getMapDataItemBasePath = (queryTypename, itemId) => {
    return `${getMapDataBasePath(queryTypename)}/${itemId}`;
};

export const getMapDataItemEditFullPath = (queryTypename, itemId) => {
    return `${getMapDataItemBasePath(queryTypename, itemId)}/edit#item-form`;
};

export const getMapDataItemReadFullPath = (queryTypename, itemId) => {
    return `${getMapDataItemBasePath(queryTypename, itemId)}/read#item-form`;
};
