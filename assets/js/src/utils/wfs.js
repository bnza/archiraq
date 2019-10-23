import {bbox, and} from 'ol/format/filter';
import {headers as headersUtil} from '@/utils/http';
import {getFilterString} from '@/utils/WFS/cql';

/**
 * @typedef {Object} QueryPaginationConfig
 *
 * @property {String} sortBy - The attribute used for sorting
 * @property {Boolean} descending
 * @property {Number} page
 * @property {Number} rowsPerPage
 *
 */

/**
 * @see https://docs.geoserver.org/latest/en/user/services/wfs/reference.html#getfeature
 * @typedef {Object} HttpGetWFSGetFeatureConfig
 *
 * @property {string} typename - The name of the feature type
 * @property {string} [projection] - The EPSG projection code. Default 'EPSG:4326'
 * @property {String} [format] - The output format. Default 'application/json'
 * @property {String} [propertyName] - Restrict a GetFeature request by attribute rather than feature
 * @property {String} [featureID] - Restrict the GetFeature request to a single feature
 * @property {String} [contentDisposition] - Set it to 'attachment' if you want that response will downloaded and saved locally.
 * @property {String} [exceptions] - The exceptions output format. Default 'application/json'
 * @property {QueryPaginationConfig} [pagination]
 * @property {module:ol/format/filter/Filter} [filter]
 */

/**
 *
 * @type {string}
 */
const getFeatureBaseQueryFragment = 'service=WFS&version=1.1.0&request=GetFeature';

export const setWfsGetFeatureRequestHeaders = (headers = {}, auth) => {
    headers = headersUtil.setAuthorizationBasic(auth, headers);
    headers = headersUtil.setContentType('text/xml', headers);
    return headers;
};

/**
 *
 * @param {module:ol/format/filter/Filter} filter
 * @return {string}
 */
const getCqlFilterQueryFragment = (filter) => {
    return '&cql_filter=' + encodeURIComponent(getFilterString(filter));
};

/**
 *
 * @param {QueryPaginationConfig} pagination
 * @return {string}
 */
const getPaginationQueryFragment = (pagination) => {
    const sortBy = (pagination.sortBy || 'id') + (pagination.descending ? '+D' : '+A');
    const startIndex = pagination.rowsPerPage * (pagination.page - 1);
    return `&maxFeatures=${pagination.rowsPerPage}&startIndex=${startIndex}&sortBy=${sortBy}`;
};

/**
 *
 * @param {HttpGetWFSGetFeatureConfig}
 * @return {string}
 */
const getFeatureBaseQueryString = ({
    typename,
    projection='EPSG:4326',
    format='application/json',
    exceptions='application/json',
    contentDisposition=''
}) => {
    let query = getFeatureBaseQueryFragment + `&typename=${typename}&srsname=${projection}&outputFormat=${format}&exceptions=${exceptions}`;
    if (contentDisposition.match(/^attachment/)) {
        query += '&content-disposition=attachment';
    }
    return query;
};

/**
 * @param {HttpGetWFSGetFeatureConfig} config
 * @return {string}
 */
export const getFeatureQueryString = (config) => {
    if (!config.hasOwnProperty('typename')) {
        throw new Error('Your config must provide a "typename" property');
    }
    if (typeof(config.typename) !== 'string') {
        throw new Error('"typename" property must be a string');
    }
    let query = getFeatureBaseQueryString(config);
    if (config.pagination) {
        query += getPaginationQueryFragment(config.pagination);
    }
    if (config.filter) {
        query +=  getCqlFilterQueryFragment(config.filter);
    }
    if (config.propertyName) {
        query += `&propertyName=${config.propertyName}`;
    }
    if (config.featureID) {
        query += `&featureID=${config.featureID}`;
    }
    return query;
};

/**
 *
 * @param geometryName
 * @param extent
 * @param opt_srsName
 * @param {import('ol/format/filter/Filter')} [filter]
 */
export const addBboxFilter = ({geometryName = 'geom', extent, opt_srsName}, filter = null) => {
    let bboxFilter = bbox(geometryName, extent, opt_srsName);
    if (filter) {
        bboxFilter = and(filter, bboxFilter);
    }
    return bboxFilter;
};

export const mapWfsFeatureToTableItem = (feature) =>{
    const item = feature.properties;
    item.geom = feature.geometry;
    return item;
};


