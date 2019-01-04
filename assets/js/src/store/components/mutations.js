import Vue from 'vue';
import {
    STORE_M_COMPONENTS_M_CREATE_COMPONENT,
    STORE_M_COMPONENTS_M_COMPONENT_PROP,
    STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP
} from '../../utils/constants';
import {getComponent} from './getters';

function validateProp(obj, prop, type) {
    if (!obj.hasOwnProperty(prop)) {
        throw new RangeError(`No "${prop}" property in component found`);
    }

    if (type && type !== typeof obj[prop]) {
        throw new TypeError(`"${prop}" must be "${type}" type "${typeof obj[prop]}" given`);
    }
}

export default {
    [STORE_M_COMPONENTS_M_CREATE_COMPONENT] (state, {cid, obj = {}}) {
        if (state.all.hasOwnProperty(cid)) {
            throw new Error(`Component "${cid}" already exist`);
        }
        Vue.set(state.all, cid, obj);
    },
    [STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP] (state, {cid, prop}) {
        const component = getComponent(state)(cid);
        validateProp(component, prop, 'boolean');
        Vue.set(component, prop, !component[prop]);
    },
    [STORE_M_COMPONENTS_M_COMPONENT_PROP] (state, {cid, prop, value}) {
        const component = getComponent(state)(cid);
        Vue.set(component, prop, value);
    }

};
