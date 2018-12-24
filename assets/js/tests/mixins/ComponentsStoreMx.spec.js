/* global describe, it, expect */
import { shallowMount, createLocalVue } from '@vue/test-utils';
import Vuex from 'vuex'
import components from '../../src/store/components'
import ComponentsStoreMx from '../../src/mixins/ComponentsStoreMx'

describe('ComponentsStoreMx', () => {
    const cid = 'dummy-component-id'

    const setupStore = (state) => {
        return new Vuex.Store({
            strict: true,
            state: {},
            modules: {
                components: {
                    namespaced: true,
                    state: state,
                    mutations: components.mutations,
                    getters: components.getters
                }
            }
        })
    }

    const setupWrapper = (state) => {
        const localVue = createLocalVue();
        localVue.use(Vuex)
        const store = setupStore(state)
        const dummy = localVue.component('dummy-component', {
            mixins: [ComponentsStoreMx],
            template: '<div></div>'
        })
        return shallowMount(dummy, {
            store,
            localVue,
            propsData: {
                cidP: cid
            }
        })
    }

    describe('lifecycle', () => {
        it('calls created hook', () => {
            const state = {
                all: {}
            }
            const wvm = setupWrapper(state)
            expect(wvm.vm.$store.state.components.all).toHaveProperty(cid, {});
        })

    })

    describe('methods', () => {
        const prop = 'dummyProp'
        const value = 56

        it('$_ComponentStoreMx_setStoreProp', () => {
            const state = {
                all: {}
            }
            const wvm = setupWrapper(state)
            wvm.vm.$_ComponentStoreMx_setStoreProp(prop, value)
            expect(wvm.vm.$store.state.components.all[cid][prop]).toBe(value)
        })

        it('$_ComponentStoreMx_getStoreProp', () => {
            const state = {
                all: {}
            }
            const wvm = setupWrapper(state)
            wvm.vm.$store.state.components.all[cid][prop] = value
            expect(wvm.vm.$_ComponentStoreMx_getStoreProp(prop)).toBe(value)
        })

        it('$_ComponentStoreMx_toggleStoreProp', () => {
            const state = {
                all: {}
            }
            const wvm = setupWrapper(state)
            wvm.vm.$store.state.components.all[cid][prop] = false
            wvm.vm.$_ComponentStoreMx_toggleStoreProp(prop)
            expect(wvm.vm.$store.state.components.all[cid][prop]).toBe(true)
            wvm.vm.$_ComponentStoreMx_toggleStoreProp(prop)
            expect(wvm.vm.$store.state.components.all[cid][prop]).toBe(false)
        })
    })
})
