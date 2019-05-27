/*eslint no-console: ["error", { allow: ["warn", "error"] }] */
import {shallowMount, createLocalVue, mount} from '@vue/test-utils';
import {Store} from 'vuex-mock-store';
import {merge} from 'lodash';
import {getNamespacedStoreProp, randomInt} from '../utils';
import {HAS_COMPONENT} from '../../../src/store/components/getters';

let localVue;
const logError = console.error;

export const StubComponent = {
    template: '<div data-test="stub"/>',
    methods: {}
};

export const catchLocalVueDuplicateVueBug = () => {
    console.error = (...args) => {
        if (
            typeof args[0] === 'string' &&
            args[0].includes('[Vuetify]') &&
            args[0].includes('https://github.com/vuetifyjs/vuetify/issues/4068')
        )
            return;
        logError(...args);
    };
};

export const resetConsoleError = () => {
    console.error = logError;
};

export const $storeMountOptions = {
    state: {
        components: {
            all: {}
        }
    },
    getters: {
        [getNamespacedStoreProp('components', HAS_COMPONENT)]: jest.fn(),
    }
};

export const resetLocaVue = () => {
    localVue = null;
};

export const getLocalVue = () => {
    if (!localVue) {
        localVue = createLocalVue();
    }
    return localVue;
};

const intValue = randomInt();
export const componentName = `DummyComponent${intValue}`;
export const cid = `DummyComponentCid${intValue}`;

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
        if (mountOptions.plugins) {
            for (let i in mountOptions.plugins) {
                localVue.use(mountOptions.plugins[i]);
            }
        }
        return {
            localVue
        };
    };
    const store = {
        mocks: {
            $store: new Store(mountOptions.$store || {})
        }
    };

    delete mountOptions.$store;

    return merge({}, defaultOptions(), mountOptions, store);
};

export const getComponent = (componentOptions) => {
    const options = getComponentOptions(componentOptions);
    return getLocalVue().component(componentName, options);
};

export const getWrapper = (mountFn, componentOptions = {}, mountOptions = {}) => {
    const component = getComponent(componentOptions);
    const options = getMountOptions(mountOptions);
    switch (mountFn) {
    case 'mount':
        return mount(component, options);
    case 'shallowMount':
        return shallowMount(component, options);
    }
};

export const getVuetifyWrapper = (mountFn, componentOptions = {}, mountOptions = {}) => {
    if (!mountOptions.plugins) {
        mountOptions.plugins = [];
    }
    const vuetify = require('vuetify');
    if (!mountOptions.plugins.includes(vuetify)) {
        mountOptions.plugins.push(vuetify);
    }
    return getWrapper(mountFn, componentOptions, mountOptions);
};
