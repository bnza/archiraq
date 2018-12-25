import Vue from 'vue';
import {getComponent} from './getters';

export const MUTATIONS = {
    CREATE: 'createComponentsStoreMutation',
    DELETE: 'deleteComponentsStoreMutation',
    SET: 'setComponentsStoreMutation',
    PROP: {
        TOGGLE: 'toggleComponentsStorePropMutation',
        SET: 'setComponentsStorePropMutation',
        DELETE: 'deleteComponentsStorePropMutation'
    }
};

function validateProp(obj, prop, type) {
    if (!obj.hasOwnProperty(prop)) {
        throw new RangeError(`No "${prop}" property in component found`);
    }

    if (type && type !== typeof obj[prop]) {
        throw new TypeError(`"${prop}" must be "${type}" type "${typeof obj[prop]}" given`);
    }
}

export default {
    [MUTATIONS.CREATE] (state, cid, obj) {
        if (state.all.hasOwnProperty(cid)) {
            throw new Error(`Component "${cid}" already exist`);
        }
        Vue.set(state.all, cid, obj || {});
    },
    [MUTATIONS.PROP.TOGGLE] (state, {cid, prop}) {
        const component = getComponent(state)(cid);
        validateProp(component, prop, 'boolean');
        Vue.set(component, prop, !component[prop]);
    },
    [MUTATIONS.PROP.SET] (state, {cid, prop, value}) {
        const component = getComponent(state)(cid);
        Vue.set(component, prop, value);
    }

};