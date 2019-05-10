import {not, like, equalTo} from 'ol/format/filter';

/**
 *
 * @param {[]} expressions
 * @param {boolean} negate
 */
export const equalToFilter = /*@__PURE__*/(expressions, negate) => {
    const filter = equalTo(expressions[0], expressions[1], true);
    return negate ? not(filter) : filter;
};

const likeFilter = /*@__PURE__*/ (expressions, matchCase) => {
    return like(expressions[0], expressions[1], '%', null, null, matchCase);
};

/**
 *
 * @param {[]} expressions
 * @param {boolean} negate
 */
const isLikeFilter = /*@__PURE__*/(expressions, negate) => {
    const filter = likeFilter(expressions, true);
    return negate ? not(filter) : filter;
};

/**
 *
 * @param {[]} expressions
 * @param {boolean} negate
 */
const isInsensitiveLikeFilter = /*@__PURE__*/(expressions, negate) => {
    const filter = likeFilter(expressions, false);
    return negate ? not(filter) : filter;
};

const wfsFilters = {
    equalToFilter,
    isInsensitiveLikeFilter,
    isLikeFilter,
};

/**
 *
 * @param {string} filter
 * @param {Array} expressions
 * @param {boolean} negate
 */
export const getWfsFilter = /*@__PURE__*/ (filter, expressions, negate = false) => {
    return wfsFilters[filter](expressions, negate);
};
