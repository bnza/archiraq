import {createEmpty, extendCoordinate, extendRings} from 'ol/extent';
import {transformExtent} from 'ol/proj';

const getExtentFromWfsGetFeaturesPoint = (extent, features) => {
    return features.reduce((extent, feature) => {
        extendCoordinate(extent, feature.geometry.coordinates);
        return extent;
    }, extent);
};

const getExtentFromWfsGetFeaturesMultiPolygon = (extent, features) => {
    return features.reduce((extent, feature) => {
        extendRings(extent, feature.geometry.coordinates[0]);
        return extent;
    }, extent);
};

const extendFns = {
    getExtentFromWfsGetFeaturesPoint,
    getExtentFromWfsGetFeaturesMultiPolygon
};

export const getExtentFromWfsGetFeatures = (data) => {
    let extent = createEmpty();
    let firstFeature = data.features[0];
    if (!firstFeature) {
        return undefined;
    }
    const extendFn = `getExtentFromWfsGetFeatures${firstFeature.geometry.type}`;
    extendFns[extendFn](extent, data.features);
    return transformExtent(extent, 'EPSG:4326', 'EPSG:3857');
};


