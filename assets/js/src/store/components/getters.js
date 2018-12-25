export const GETTERS = {
    GET: 'getComponentsStoreComponentGetter',
    PROP: {
        GET: 'getComponentsStoreComponentPropGetter'
    }
};

export const getComponent = (state) => (id) => {
    if (!state.all.hasOwnProperty(id)) {
        throw new ReferenceError(`No "${id}" component found`);
    }
    return state.all[id];
};

export default {
    [GETTERS.GET]: getComponent,
    [GETTERS.PROP.GET]: (state, getter) => (id, prop) => {
        const component = getter[GETTERS.GET](id);
        if (!component.hasOwnProperty(prop)) {
            throw new ReferenceError(`No "${prop}" property in "${id}" component found`);
        }
        return component[prop];
    }
};