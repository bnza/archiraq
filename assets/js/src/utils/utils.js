/*eslint no-console: ["error", { allow: ["warn", "error"] }] */

/**
 * @typedef {Object} Callee
 * @property {string} method the object method which will be called
 * @property {Array} args The method arguments
 */

/**
 * Call the object method with the given arguments
 * @param {Object} obj
 * @param {Callee} callee
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
