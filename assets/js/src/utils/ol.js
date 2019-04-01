import GeoJSON from 'ol/format/GeoJSON';

/**
 *
 * @param {string }geoJson
 * @return {GeoJSONGeometry}
 */
export const olGeoJsonReadGeometry = (geoJson) => {
    return (new GeoJSON()).readGeometryFromObject(JSON.parse(geoJson));
};
