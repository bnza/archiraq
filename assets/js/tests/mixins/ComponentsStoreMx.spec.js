import ComponentsStoreMx from '../../src/mixins/ComponentsStoreMx'
import {cid, getNamespacedStoreFunc, getWrapper, moduleFuncs} from "./utils";
import {propName, propIntValue} from "../store/utils";

let componentOptions

beforeEach(() => {
    componentOptions = {
        mixins: [ComponentsStoreMx],
        data: function () {
            return {
                $_ComponentStoreMx_cid: cid
            }
        }
    }
})

describe('ComponentsStoreMx', () => {
    describe('lifecycle', () => {
        const testWrapper = (mountFn, componentOptions, mountOptions, times) => {
            const wrapper = getWrapper(mountFn, componentOptions, mountOptions)
            expect(wrapper.vm.$store.commit).toHaveBeenCalledTimes(times)
            if (times) {
                expect(wrapper.vm.$store.commit).toHaveBeenCalledWith(getNamespacedStoreFunc(moduleFuncs.MUTATIONS.CREATE), cid, undefined)
            }

        }

        it('calls created hook wit data cid', () => {
            testWrapper('shallowMount', componentOptions, {}, 1)
        })

        it('calls created hook with cidP', () => {
            delete componentOptions.data
            const mountOptions = {
                propsData: {
                    cidP: cid
                }
            }
            testWrapper('shallowMount', componentOptions, mountOptions, 1)
        })

        it('not calls created hook when no cid', () => {
            delete componentOptions.data
            testWrapper('shallowMount', componentOptions, {}, 0)
        })
    })

    describe('methods', () => {
        it(`$_ComponentStoreMx_setStoreProp`, () => {
            const wrapper = getWrapper('shallowMount', componentOptions, {})
            wrapper.vm.$_ComponentStoreMx_setStoreProp(propName, propIntValue)
            expect(wrapper.vm.$store.commit).toHaveBeenLastCalledWith(
                getNamespacedStoreFunc(moduleFuncs.MUTATIONS.PROP.SET),
                {
                    cid: cid,
                    prop: propName,
                    value: propIntValue
                },
                undefined
            )
        })

        it(`$_ComponentStoreMx_getStoreProp`, () => {
            const wrapper = getWrapper('shallowMount', componentOptions, {})
            wrapper.vm.$_ComponentStoreMx_getStoreProp(propName)
            let jestFn = wrapper.vm[moduleFuncs.GETTERS.PROP.GET]
            expect(jestFn).toHaveBeenCalledTimes(1)
            expect(jestFn).toHaveBeenLastCalledWith(
                cid,
                propName
            )
        })

        it('$_ComponentStoreMx_toggleStoreProp', () => {
            const wrapper = getWrapper('shallowMount', componentOptions, {})
            wrapper.vm.$_ComponentStoreMx_toggleStoreProp(propName)
            expect(wrapper.vm.$store.commit).toHaveBeenLastCalledWith(
                getNamespacedStoreFunc(moduleFuncs.MUTATIONS.PROP.TOGGLE),
                {
                    cid: cid,
                    prop: propName
                },
                undefined
            )
        })
    })


})