import { shallowMount, createLocalVue } from '@vue/test-utils';
import merge from 'lodash/merge';
import MODULE_FUNCS from '../../src/store/components/module-funcs';
import {propIntValue} from '../store/utils';
import {getStore} from '../store/utils';

export const moduleFuncs = MODULE_FUNCS;

const namespace = 'components';
let localVue;

export const getNamespacedStoreFunc = (func) => {
    return `${namespace}/${func}`;
};

export const getLocalVue = () => {
    if (!localVue) {
        localVue = createLocalVue();
    }
    return localVue;
};

export const componentName = (() => `dummy-component-${propIntValue}`)();
export const cid = (() => `dummy-component-id-${propIntValue}`)();

export const getComponentOptions = (componentOptions) => {
    const defaultOptions = () => {
        return {
            name: componentName,
            template: '<div></div>'
        };
    };

    let options = defaultOptions();
    return merge({}, options, componentOptions);
};

export const getMountOptions = (mountOptions) => {
    const defaultOptions = () => {
        const localVue = getLocalVue();
        return {
            localVue
        };
    };
    mountOptions.store = getStore(getLocalVue(),mountOptions.store || {});
    return merge({}, defaultOptions(), mountOptions);
};

export const getComponent = (componentOptions) => {
    const options = getComponentOptions(componentOptions);
    return getLocalVue().component(componentName, options);
};

export const getWrapper = (mountFn, componentOptions = {}, mountOptions = {}) => {
    const component = getComponent(componentOptions);
    const options = getMountOptions(mountOptions);
    switch (mountFn) {
    case 'shallowMount':
        return shallowMount(component, options);
    }
};