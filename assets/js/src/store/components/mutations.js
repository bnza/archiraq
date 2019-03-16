import Vue from 'vue';
import {getComponent} from './getters';

export const CREATE_COMPONENT = 'createComponent';
export const SET_COMPONENT_PROP = 'setComponentProp';
export const TOGGLE_COMPONENT_PROP = 'toggleComponentProp';

function validateProp(obj, prop, type) {
    if (!obj.hasOwnProperty(prop)) {
        throw new RangeError(`No "${prop}" property in component found`);
    }

    if (type && type !== typeof obj[prop]) {
        throw new TypeError(`"${prop}" must be "${type}" type "${typeof obj[prop]}" given`);
    }
}

export default {
    [CREATE_COMPONENT] (state, {cid, obj = {}}) {
        if (state.all.hasOwnProperty(cid)) {
            throw new Error(`Component "${cid}" already exist`);
        }
        Vue.set(state.all, cid, obj);
    },
    [TOGGLE_COMPONENT_PROP] (state, {cid, prop}) {
        const component = getComponent(state)(cid);
        validateProp(component, prop, 'boolean');
        Vue.set(component, prop, !component[prop]);
    },
    [SET_COMPONENT_PROP] (state, {cid, prop, value}) {
        const component = getComponent(state)(cid);
        Vue.set(component, prop, value);
    }

};
