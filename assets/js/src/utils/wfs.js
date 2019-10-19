import {WFS} from 'ol/format.js';
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

/**
 *
 * @param {float[]} extent the request extension
 * @param {float} resolution
 * @param {string} projection
 * @param {string} typename
 * @param {Filter} filter
 * @return {{filter: Filter, srsName: string, geometryName: string, featureNS: string, bbox: float[], featureTypes: string[], featurePrefix: string, outputFormat: string}}
 */
const getBboxWriteGetFeatureOptions = /*@__PURE__*/ (extent, resolution, projection, typename, filter) => {
    return {
        featureNS: 'http://archiraq.orientlab.net',
        featurePrefix: 'archiraq',
        srsName: projection,
        featureTypes: [typename],
        outputFormat: 'application/json',
        geometryName: 'geom',
        bbox: extent,
        filter: filter,
    };
};

export const getBboxFeatureRequestXmlBody = (extent, resolution, projection, typename, filter) => {
    const options = getBboxWriteGetFeatureOptions(extent, resolution, projection, typename, filter);
    const featureRequest =  new WFS().writeGetFeature(options);
    return new XMLSerializer().serializeToString(featureRequest);
};

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
    typename, projection='EPSG:4326',
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
    return query;
};

/**
 * @param {HttpGetWFSGetFeatureConfig} config
 * @return {string}
 */
export const getFeatureBboxQueryString = (config, {geometryName = 'geom', extent, opt_srsName}) => {
    const bboxFilter = bbox(geometryName, extent, opt_srsName);
    if (config.filter) {
        config.filter = and(config.filter, bboxFilter);
    } else {
        config.filter = bboxFilter;
    }
    return getFeatureQueryString(config);
};

export const mapWfsFeatureToTableItem = (feature) =>{
    const item = feature.properties;
    item.geom = feature.geometry;
    return item;
};


