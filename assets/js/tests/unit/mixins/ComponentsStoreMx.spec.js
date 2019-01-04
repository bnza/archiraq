import {
    STORE_M_COMPONENTS_M_CREATE_COMPONENT,
    STORE_M_COMPONENTS_M_COMPONENT_PROP,
    STORE_M_COMPONENTS_G_COMPONENT_PROP,
    STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP

} from '../../../src/utils/constants';
import ComponentsStoreMx from '../../../src/mixins/ComponentsStoreMx';
import {cid, getNamespacedStoreFunc, getWrapper} from './utils';
import {propName, propIntValue} from '../store/utils';

let componentOptions;

beforeEach(() => {
    componentOptions = {
        mixins: [ComponentsStoreMx],
        data: function () {
            return {
                componentStoreMx_cid: cid
            };
        }
    };
});

describe('ComponentsStoreMx', () => {
    describe('lifecycle', () => {
        const testWrapper = (mountFn, componentOptions, mountOptions, times) => {
            const wrapper = getWrapper(mountFn, componentOptions, mountOptions);
            expect(wrapper.vm.$store.commit).toHaveBeenCalledTimes(times);
            if (times) {
                expect(
                    wrapper.vm.$store.commit
                ).toHaveBeenCalledWith(
                    getNamespacedStoreFunc(STORE_M_COMPONENTS_M_CREATE_COMPONENT),
                    {cid},
                    undefined
                );
            }

        };

        it('calls created hook wit data cid', () => {
            testWrapper('shallowMount', componentOptions, {}, 1);
        });

        it('calls created hook with cidP', () => {
            delete componentOptions.data;
            const mountOptions = {
                propsData: {
                    cidP: cid
                }
            };
            testWrapper('shallowMount', componentOptions, mountOptions, 1);
        });

        it('not calls created hook when no cid', () => {
            delete componentOptions.data;
            testWrapper('shallowMount', componentOptions, {}, 0);
        });
    });

    describe('methods', () => {
        it('componentStoreMx_setStoreProp', () => {
            const wrapper = getWrapper('shallowMount', componentOptions, {});
            wrapper.vm.componentStoreMx_setStoreProp(propName, propIntValue);
            expect(wrapper.vm.$store.commit).toHaveBeenLastCalledWith(
                getNamespacedStoreFunc(STORE_M_COMPONENTS_M_COMPONENT_PROP),
                {
                    cid: cid,
                    prop: propName,
                    value: propIntValue
                },
                undefined
            );
        });

        it('componentStoreMx_getStoreProp', () => {
            const wrapper = getWrapper('shallowMount', componentOptions, {});
            wrapper.vm.componentStoreMx_getStoreProp(propName);
            let jestFn = wrapper.vm[STORE_M_COMPONENTS_G_COMPONENT_PROP];
            expect(jestFn).toHaveBeenCalledTimes(1);
            expect(jestFn).toHaveBeenLastCalledWith(
                cid,
                propName
            );
        });

        it('componentStoreMx_toggleStoreProp', () => {
            const wrapper = getWrapper('shallowMount', componentOptions, {});
            wrapper.vm.componentStoreMx_toggleStoreProp(propName);
            expect(wrapper.vm.$store.commit).toHaveBeenLastCalledWith(
                getNamespacedStoreFunc(STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP),
                {
                    cid: cid,
                    prop: propName
                },
                undefined
            );
        });
    });


});
