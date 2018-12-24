import merge from 'lodash/merge'
import Vuex from 'vuex'
import {options as appStoreOptions} from '../../src/store/options'

const randomMax = 1000

export const propIntValue = (() => Math.floor(Math.random() * (randomMax)))()
export const propName = (() => `dummyProp${propIntValue}`)()
export const propStringValue = (() => `dummy prop string ${propIntValue}`)()
export const propBooleanValue = (() => !!(propIntValue > (randomMax/2)))()
export const propArrayValue = (() => [propIntValue])()
export const propObjectValue = (() => {return {[propName]: propIntValue}})()

const getAppStoreModuleOptions = (namespace) => {
    if (!namespace) {
        return appStoreOptions
    } else if (appStoreOptions.hasOwnProperty('modules') && appStoreOptions.modules.hasOwnProperty(namespace)) {
        return appStoreOptions.modules[namespace]
    }
    throw new ReferenceError(`No "${namespace}" in store`)
}

const getMutationsOptions = (module, mutations) => {
    const mockedMutations = {}
    mutations = mutations || {}
    for (let key in module.mutations) {
        mockedMutations[key] = mutations[key] || jest.fn()
    }
    return mockedMutations
}

const getGettersOptions = (module, getters) => {
    const mockedGetters = {}
    getters = getters || {}
    for (let key in module.getters) {
        if (getters[key]) {
            mockedGetters[key] = jest.fn(() => getters[key])
        } else {
            let getter = () => jest.fn()
            mockedGetters[key] = getter
        }
    }
    return mockedGetters
}

const getStateOptions = (module, state) => {
    return merge({},state || {}, module.state)
}

export const getStoreModuleOptions = ({state, mutations, getters, actions}, namespace) => {
    const module = getAppStoreModuleOptions(namespace)
    return {
        namespaced: !!namespace && !!module.namespaced,
        state: getStateOptions(module, state),
        getters: getGettersOptions(module, getters),
        mutations: getMutationsOptions(module, mutations),
    }
    return module
}

export const getStoreOption = (options) => {
    let mockedOptions = getStoreModuleOptions(options)
    if (appStoreOptions.hasOwnProperty('modules')) {
        mockedOptions.modules = {}
        for (module in appStoreOptions.modules) {
            mockedOptions.modules[module] = getStoreModuleOptions(options, module)
        }
    }
    return mockedOptions
}

export const getStore = (localVue, options, namespace) => {
    let mockedOptions

    if (namespace) {
        mockedOptions = {
            modules: {
                [namespace]: getStoreModuleOptions(options, namespace)
            }
        }
    } else {
        mockedOptions = getStoreOption(options)
    }
    localVue.use(Vuex)
    let store = new Vuex.Store(mockedOptions)
    store.commit = jest.fn()
    store.dispatch = jest.fn()
    return store
}

