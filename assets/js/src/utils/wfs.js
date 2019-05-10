import {WFS} from 'ol/format.js';
import {headers as headersUtil} from '@/utils/http';
import {getFilterString} from '@/utils/WFS/cql';

/**
 *
 * @param {float[]} extent the request extension
 * @param {float} resolution
 * @param {string} projection
 * @param {string} typename
 * @param {Filter} filter
 * @return {{filter: Filter, srsName: string, geometryName: string, featureNS: string, bbox: float[], featureTypes: string[], featurePrefix: string, outputFormat: string}}
 */
export const getBboxWriteGetFeatureOptions = /*@__PURE__*/ (extent, resolution, projection, typename, filter) => {
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

export const setWfsGetFeaturePostRequestHeaders = (headers = {}, auth) => {
    headers = headersUtil.setAuthorizationBasic(auth, headers);
    headers = headersUtil.setContentType('text/xml', headers);
    return headers;
};

export const getCqlFilterQuery = (filter) => {
    return '&cql_filter=' + encodeURIComponent(getFilterString(filter));
};

export const getWfsGetFeatureQueryString = (projection, typename, filter, pagination) => {
    const sortBy = (pagination.sortBy || 'id') + (pagination.descending ? '+D' : '+A');
    const startIndex = pagination.rowsPerPage * (pagination.page - 1);
    let query = 'service=WFS&' +
        'version=1.1.0&request=GetFeature&typename=' + typename + '&' +
        'outputFormat=application/json&srsname=' + projection + '&' +
        'maxFeatures=' + pagination.rowsPerPage + '&' +
        'startIndex=' + startIndex + '&' +
        'sortBy=' + sortBy;
    if (filter) {
        query +=  getCqlFilterQuery(filter);
    }
    return query;
};

export const mapWfsFeatureToTableItem = (feature) =>{
    const item = feature.properties;
    item.geom = feature.geometry;
    return item;
};


