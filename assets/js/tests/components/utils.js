/*eslint no-console: ["error", { allow: ["warn", "error"] }] */
import Vuetify from 'vuetify';
import {mount, shallowMount} from '@vue/test-utils';
import {getLocalVue, getMountOptions} from '../mixins/utils';

const logError = console.error;

export const catchLocalVueDuplicateVueBug = () => {
    console.error = (...args) => {
        if (
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

export const getWrapper = (mountFn, component, mountOptions = {}) => {
    getLocalVue().use(Vuetify);
    const options = getMountOptions(mountOptions);
    switch (mountFn) {
    case 'mount':
        return mount(component, options);
    case 'shallowMount':
        return shallowMount(component, options);
    }
};