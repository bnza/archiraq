export const HAS_COMPONENT = 'hasComponent';
export const GET_COMPONENT = 'getComponent';
export const GET_COMPONENT_PROP = 'getComponentProp';

export const getComponent = (state) => (id) => {
/*    if (!state.all.hasOwnProperty(id)) {
        throw new ReferenceError(`No "${id}" component found`);
    }*/
    return state.all[id] || {};
};

export default {
    [HAS_COMPONENT]: (state) => (id) => {
        return state.all.hasOwnProperty(id);
    },
    [GET_COMPONENT]: getComponent,
    [GET_COMPONENT_PROP]: (state, getter) => (id, prop) => {
        const component = getter[GET_COMPONENT](id);
        return component[prop];
    }
};
