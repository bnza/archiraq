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
 *
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

/**
 * Downloads URI as an attachment
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/a
 * @param {String} uri - The resource URI
 * @param {String} filename - The "download" <a> attribute value
 * @param {HTMLElement} el - The element where to append the temporary <a>
 */
export const downloadAttachment = (uri, filename='', el=null) => {
    el = el || document.body;
    const a = document.createElement('a');
    a.setAttribute('href', uri);
    a.setAttribute('download', filename);
    a.setAttribute('target', '_blank');

    a.style.display = 'none';
    el.appendChild(a);

    a.click();

    el.removeChild(a);
};

/**
 * Returns the human readable text status
 * @param status
 * @return {string}
 */
export const getStatusText  = (status) => {
    let text = 'NONE';
    if (status.isRunning) {
        text =  'RUNNING';
    } else if (status.isError) {
        text =  'ERROR';
    } else if (status.isCancelled) {
        text =  'CANCELLED';
    } else if (status.isSuccessful) {
        text =  'SUCCESS';
    }
    return text;
};

/**
 *
 * @param status
 * @return {string}
 */
export const getStatusIcon = (status) => {
    let icon = 'help_outline';
    if (status.isRunning) {
        icon =  'settings_backup_restore';
    } else if (status.isError) {
        icon =  'error_outline';
    } else if (status.isCancelled) {
        icon =  'highlight_off';
    } else if (status.isSuccessful) {
        icon =  'check_circle_outline';
    }
    return icon;
};

/**
 *
 * @param status
 * @return {string}
 */
export const getStatusColor = (status) => {
    let color = 'grey';
    if (status.isRunning) {
        color =  'indigo darken2';
    } else if (status.isError) {
        color =  'red darken2';
    } else if (status.isCancelled) {
        color =  'red darken2';
    } else if (status.isSuccessful) {
        color =  'green darken2';
    }
    return color;
};

/**
 * Return the runnable (job, task) progress percentage
 * @param runnable
 * @param precision
 * @return {string}
 */
export const getProgressPercentage = (runnable, precision = 2) => {
    return Math.floor( runnable.currentStepNum / runnable.stepsNum * 100).toFixed(precision);
};

/**
 * Return the runnable (job, task) progress percentage
 * @param job
 * @param precision
 * @return {string}
 */
export const getJobProgressPercentage = (job, precision = 2) => {
    if (job.status.isSuccessful) {
        return '100.00';
    }
    let currentTaskProgress = parseFloat(getProgressPercentage(job.tasks[job.currentStepNum]))/job.stepsNum;
    return (parseFloat(getProgressPercentage(job, precision)) + currentTaskProgress).toFixed();
};
