import {not, or, like, equalTo} from 'ol/format/filter';

/**
 *
 * @param {Filter} filter
 * @param {boolean} negate
 */
const maybeNegate = /*@__PURE__*/(filter, negate) => {
    return negate ? not(filter) : filter;
};

/**
 *
 * @param {[]} expressions
 * @param {boolean} negate
 */
const equalToFilter = /*@__PURE__*/(expressions, negate) => {
    const filter = equalTo(expressions[0], expressions[1], true);
    return maybeNegate(filter, negate);
};

/**
 *
 * @param {[]} expressions
 * @param {boolean} negate
 */
const multipleEqualToFilter = /*@__PURE__*/(expressions, negate) => {
    if (expressions[1].length === 1) {
        return equalToFilter(expressions, negate);
    }
    const filters = expressions[1].map((expression) => {
        return equalTo(expressions[0], expression);
    });
    const filter = or(...filters);
    return maybeNegate(filter, negate);
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
    return maybeNegate(filter, negate);
};

/**
 *
 * @param {[]} expressions
 * @param {boolean} negate
 */
const isInsensitiveLikeFilter = /*@__PURE__*/(expressions, negate) => {
    const filter = likeFilter(expressions, false);
    return maybeNegate(filter, negate);
};

const wfsFilters = {
    equalToFilter,
    isInsensitiveLikeFilter,
    isLikeFilter,
    multipleEqualToFilter
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
