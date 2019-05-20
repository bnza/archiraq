/*eslint no-console: ["error", { allow: ["warn", "error"] }] */
import {camelCase, upperFirst} from 'lodash';
/**
 * @typedef {Object} Callee
 * @property {string} method the object method which will be called
 * @property {Array} args The method arguments
 */

/**
 * Call the object method with the given arguments
 * @param {Object} obj
 * @param {Callee} callee
 * @param {boolean} throws
 */
export const callObjectMethod = (obj, callee, throws = false) => {
    let error = '';
    if (callee === null) {
        return;
    } else if (typeof callee === 'object') {
        if (callee.hasOwnProperty('method')) {
            if (typeof callee.method === 'string') {
                if (typeof obj[callee.method] === 'function') {
                    let args = callee.hasOwnProperty('args') ? callee.args : [];
                    if (!Array.isArray(args)) {
                        args = [args];
                    }
                    return obj[callee.method](...args);
                } else {
                    error = `Object["${callee.method}"] is not a function`;
                }
            } else {
                error = 'Callee "method" property value must be a string';
            }
        } else {
            error = 'Invalid callee signature (no "method" property)';
        }
    } else {
        error = 'Invalid callee type';
    }

    if (error) {
        if (throws) {
            throw new TypeError(error);
        } else {
            console.warn(error);
        }
    }
};

/**
 *
 * @param {boolean} isFullScreen
 * @return {string} the map height e.g. '500px'
 */
export const getMapPixelHeight = (isFullScreen) => {
    return getMapIntPixelHeight(isFullScreen ? window.innerHeight : false) + 'px';
};

/**
 *
 * @param innerHeight
 * @return {number} the map height in pixel
 * @private
 */
const getMapIntPixelHeight = /*@__PURE__*/ (innerHeight) => {
    let height = 500;
    if (innerHeight) {
        const mainToolbarHeight = 64;
        const mainFooterHeight = 36;

        height = innerHeight - (mainToolbarHeight + mainFooterHeight);
    }
    return height;
};

export const pascalCase = (string) => {
    return upperFirst(camelCase(string));
};

/**
 * Check given array index existence
 * @param {Array} arr - The array to check
 * @param {Number|Number[]} idx - Index[es]
 * @return {boolean}
 */
export const arrayHasIndex = (arr, idx) => {
    if (Array.isArray(idx)) {
        return idx.reduce((hasIndex, i) => {
            return hasIndex && arrayHasIndex(arr, i);
        }, true);
    }
    return arr[idx] !== void 0;
};
