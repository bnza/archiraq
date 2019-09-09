import {lowerFirst, cloneDeep} from 'lodash';
import {not, or, like, equalTo} from 'ol/format/filter';
import {arrayHasIndex} from '@/utils/utils';

/**
 * The raw condition/predicate object
 * @see https://docs.geoserver.org/stable/en/user/filter/ecql_reference.html
 * @typedef {Object} CQLCondition
 * @property {boolean} negate - Indicates whether condition/predicate will be negate
 * @property {string} operator - The CQL comparision operator mainly the ol ones
 * @property {Array} expressions - The CQL comparision expression's values
 *
 */

/**
 * Two item array used by binary comparision operators in the form [attribute, value]
 * @typedef {Array} CQLBinaryExpressions
 */

/**
 * Wrap like filter pattern with "%" wildcard
 * @param pattern
 * @return {string}
 */
export const wildcardWrap = /*@__PURE__*/(pattern) => {
    return `%${pattern}%`;
};

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
 * @param {CQLBinaryExpressions} expressions
 * @return {boolean}
 */
const binaryPredicateIsValid = (expressions) => {
    return arrayHasIndex(expressions, [0, 1]);
};

/**
 *
 * @param {CQLBinaryExpressions} expressions
 * @param {boolean} negate
 */
const equalToFilter = /*@__PURE__*/(expressions, negate) => {
    if (!binaryPredicateIsValid(expressions)) {
        return null;
    }
    const filter = equalTo(expressions[0], expressions[1], true);
    return maybeNegate(filter, negate);
};

/**
 *
 * @param {CQLBinaryExpressions} expressions
 * @param {boolean} negate
 */
const multipleEqualToFilter = /*@__PURE__*/(expressions, negate) => {
    const _expressions = cloneDeep(expressions);
    if (!binaryPredicateIsValid(_expressions)) {
        return null;
    }
    if (_expressions[1].length === 1) {
        _expressions[1] = _expressions[1].pop();
        return equalToFilter(_expressions, negate);
    }
    const filters = _expressions[1].map((expression) => {
        return equalTo(_expressions[0], expression, true);
    });
    const filter = or(...filters);
    return maybeNegate(filter, negate);
};


/**
 *
 * @param {CQLBinaryExpressions} expressions
 * @param {boolean} negate
 */
const multipleIsInsensitiveLikeFilter = /*@__PURE__*/(expressions, negate) => {
    let _expressions = cloneDeep(expressions);
    if (!binaryPredicateIsValid(_expressions)) {
        return null;
    }
    if (_expressions[1].length === 1) {
        _expressions[1] = wildcardWrap(_expressions[1].pop());
        return isInsensitiveLikeFilter(_expressions, negate);
    }
    const filters = _expressions[1].map((expression) => {
        return likeFilter([_expressions[0], wildcardWrap(expression)], false);
    });
    const filter = or(...filters);
    return maybeNegate(filter, negate);
};

const likeFilter = /*@__PURE__*/ (expressions, matchCase) => {
    return like(expressions[0], expressions[1], '%', null, null, matchCase);
};

/**
 *
 * @param {CQLBinaryExpressions} expressions
 * @param {boolean} negate
 */
const isLikeFilter = /*@__PURE__*/(expressions, negate) => {
    if (!binaryPredicateIsValid(expressions)) {
        return null;
    }
    const filter = likeFilter(expressions, true);
    return maybeNegate(filter, negate);
};

/**
 *
 * @param {CQLBinaryExpressions} expressions
 * @param {boolean} negate
 */
const isInsensitiveLikeFilter = /*@__PURE__*/(expressions, negate) => {
    if (!binaryPredicateIsValid(expressions)) {
        return null;
    }
    const filter = likeFilter(expressions, false);
    return maybeNegate(filter, negate);
};

/**
 *
 * @param {CQLBinaryExpressions} expressions
 * @param {boolean} negate
 */
const stringContainsFilter = /*@__PURE__*/(expressions, negate) => {
    if (!binaryPredicateIsValid(expressions)) {
        return null;
    }
    const filter = likeFilter([expressions[0], wildcardWrap(expressions[1])], false);
    return maybeNegate(filter, negate);
};

const surveyRefsMatchFilter = /*@__PURE__*/(expressions, negate) => {
    let pattern = '';
    if (!expressions[1] && !expressions[2]) {
        return null;
    }
    if (expressions[1]) {
        pattern = `${expressions[1]}.`.toUpperCase();
    } else {
        pattern += '%.';
    }
    if (expressions[2]) {
        pattern += `${expressions[2]}%`;
    } else {
        pattern += '%';
    }

    const filter = likeFilter([expressions[0], pattern], false);
    return maybeNegate(filter, negate);
};

const wfsFilters = {
    equalToFilter,
    isInsensitiveLikeFilter,
    isLikeFilter,
    stringContainsFilter,
    surveyRefsMatchFilter,
    multipleEqualToFilter,
    multipleIsInsensitiveLikeFilter
};

/**
 *
 * @param {string} filter
 * @param {CQLBinaryExpressions} expressions
 * @param {boolean} negate
 * @return {Filter}
 */
export const getWfsFilter = /*@__PURE__*/ (filter, expressions, negate = false) => {
    return wfsFilters[filter](expressions, negate);
};

/**
 * Return an ol Filter
 * @param {CQLCondition} condition - The condition
 * @return {?Filter}
 */
export const getNullableWfsFilter = condition => {
    try {
        const filterFn = lowerFirst(condition.operator);
        return condition.operator
            ? getWfsFilter(filterFn, condition.expressions, condition.negate)
            : null;
    } catch (e) {
        return null;
    }
};

/**
 * Converts cql conditions in ol filters
 * @param {CQLCondition[]} conditions
 * @return {Filter[]}
 */
export const getConditionsWfsFilters = conditions => {
    const filters = [];
    let condition;
    let filter;
    for (let key in conditions) {
        condition = conditions[key];
        filter=getNullableWfsFilter(condition);
        if (filter) {
            filters.push(filter);
        }
    }
    return filters;
};

