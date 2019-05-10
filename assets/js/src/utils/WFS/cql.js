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

const functions = {
    getAndFilterString,
    getNotFilterString,
    getPropertyIsEqualToFilterString,
    getPropertyIsLikeFilterString
};

export const getFilterString = (filter) => {
    const fn = `get${filter.tagName_}FilterString`;
    return functions[fn](filter);
};
