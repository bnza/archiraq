import {WFS} from 'ol/format.js';

/**
 *
 * @param {float[]} extent the request extension
 * @param {float} resolution
 * @param {string} projection
 * @param {string} typename
 * @param {Filter} filter
 * @return {{srsName: *, featureNS: string, featureTypes: *[], version: string, featurePrefix: string, outputFormat: string}}
 */
export const getWriteGetFeatureOptions = (extent, resolution, projection, typename, filter) => {
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

export const getFeatureRequestXmlBody = (extent, resolution, projection, typename, filter) => {
    const options = getWriteGetFeatureOptions(extent, resolution, projection, typename, filter);
    const featureRequest =  new WFS().writeGetFeature(options);
    return new XMLSerializer().serializeToString(featureRequest);
};
