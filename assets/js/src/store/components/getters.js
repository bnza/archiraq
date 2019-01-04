import {STORE_M_COMPONENTS_G_COMPONENT, STORE_M_COMPONENTS_G_COMPONENT_PROP} from '../../utils/constants';

export const getComponent = (state) => (id) => {
    if (!state.all.hasOwnProperty(id)) {
        throw new ReferenceError(`No "${id}" component found`);
    }
    return state.all[id];
};

export default {
    [STORE_M_COMPONENTS_G_COMPONENT]: getComponent,
    [STORE_M_COMPONENTS_G_COMPONENT_PROP]: (state, getter) => (id, prop) => {
        const component = getter[STORE_M_COMPONENTS_G_COMPONENT](id);
        if (!component.hasOwnProperty(prop)) {
            throw new ReferenceError(`No "${prop}" property in "${id}" component found`);
        }
        return component[prop];
    }
};
