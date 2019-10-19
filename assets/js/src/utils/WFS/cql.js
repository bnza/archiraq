/**
 *
 * @param {And} filter
 * @return {string}
 */
const getAndFilterString = (filter) => {
    const conditions = filter.conditions.map(getFilterString);
    return conditions.join(' AND ');
};

/**
 *
 * @param {Or} filter
 * @return {string}
 */
const getOrFilterString = (filter) => {
    const conditions = filter.conditions.map(getFilterString);
    return conditions.join(' OR ');
};

/**
 *
 * @param {And} filter
 * @return {string}
 */
const getNotFilterString = (filter) => {
    return `NOT (${getFilterString(filter.condition)})`;
};

/**
 *
 * @param {EqualTo} filter
 * @return {string}
 */
const getPropertyIsEqualToFilterString = (filter) => {
    return `${filter.propertyName} = '${filter.expression}'`;
};

/**
 *
 * @param {IsLike} filter
 * @return {string}
 */
const getPropertyIsLikeFilterString = (filter) => {
    const operator = filter.matchCase ? 'LIKE' : 'ILIKE';
    return `${filter.propertyName} ${operator} '${filter.pattern}'`;
};

const getBBOXFilterString = (filter) => {
    const extent = filter.extent.join(',');
    return `BBOX(${filter.geometryName},${extent},'EPSG:4326')`;
};

const functions = {
    getAndFilterString,
    getNotFilterString,
    getOrFilterString,
    getPropertyIsEqualToFilterString,
    getPropertyIsLikeFilterString,
    getBBOXFilterString
};

export const getFilterString = (filter) => {
    const fn = `get${filter.tagName_}FilterString`;
    return functions[fn](filter);
};
