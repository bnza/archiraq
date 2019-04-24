import {SET_COMPONENT_PROP} from '../../../src/store/components/mutations';
import {GET_COMPONENT_PROP, HAS_COMPONENT} from '../../../src/store/components/getters';
import ComponentStoreVisibleMx from '../../../src/mixins/ComponentStoreVisibleMx';
import {cid, getWrapper} from '../components/utils';
import {getNamespacedStoreProp} from '../utils';


let componentOptions;

beforeEach(() => {
    componentOptions = {
        mixins: [ComponentStoreVisibleMx],
        data: function () {
            return {
                cid: cid
            };
        }
    };
});

describe('ComponentsStoreMx', () => {
    describe('lifecycle', () => {
        it('created set default visible value', () => {
            const getStoreProp = jest.fn();
            const mountOptions = {
                $store: {
                    state: {
                        components: {
                            all: {}
                        }
                    },
                    getters: {
                        [getNamespacedStoreProp('components', HAS_COMPONENT)]: jest.fn(),
                        [getNamespacedStoreProp('components', GET_COMPONENT_PROP)]: getStoreProp,
                    }
                }
            };
            const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
            expect(wrapper.vm.$store.commit).toHaveBeenCalledWith(
                getNamespacedStoreProp('components', SET_COMPONENT_PROP),
                {cid, prop: 'visible', value: false}
            );
        });
        it('created set prop visible value', () => {
            const getStoreProp = jest.fn();
            const mountOptions = {
                $store: {
                    state: {
                        components: {
                            all: {}
                        }
                    },
                    getters: {
                        [getNamespacedStoreProp('components', HAS_COMPONENT)]: jest.fn(),
                        [getNamespacedStoreProp('components', GET_COMPONENT_PROP)]: getStoreProp,
                    }
                },
                propsData: {
                    visibleP: true
                }
            };
            const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
            expect(wrapper.vm.$store.commit).toHaveBeenCalledWith(
                getNamespacedStoreProp('components', SET_COMPONENT_PROP),
                {cid, prop: 'visible', value: true}
            );
        });
    });
    describe('computed', () => {
        it('visible get value from store', () => {
            const getStoreProp = jest.fn();
            const mountOptions = {
                $store: {
                    state: {
                        components: {
                            all: {}
                        }
                    },
                    getters: {
                        [getNamespacedStoreProp('components', HAS_COMPONENT)]: jest.fn(),
                        [getNamespacedStoreProp('components', GET_COMPONENT_PROP)]: getStoreProp,
                    }
                }
            };
            const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
            const visible = wrapper.vm.visible;
            expect(getStoreProp).toBeCalledWith(cid, 'visible');
        });
    });
    describe('methods', () => {
        describe('syncVisible', () => {
            it('setProp will be called only when event value and stored one differ', () => {
                const mountOptions = {
                    $store: {
                        state: {
                            components: {
                                all: {}
                            }
                        },
                        getters: {
                            [getNamespacedStoreProp('components', HAS_COMPONENT)]: jest.fn().mockReturnValueOnce(true)
                        }
                    },
                    methods: {
                        getProp: jest.fn().mockReturnValueOnce(false),
                        setProp: jest.fn()
                    }
                };
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.syncVisible(false);
                // Once called in created lifecycle
                expect(mountOptions.methods.setProp).toHaveBeenCalledTimes(1);
                wrapper.vm.syncVisible(true);
                expect(mountOptions.methods.setProp).toHaveBeenCalledTimes(2);
                expect(mountOptions.methods.setProp.mock.calls[1][1]).toEqual(true);
            });

        });
    });
});
