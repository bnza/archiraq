import {STORE} from '../../src/store/store-funcs'
import {state, getters} from '../../src/store'
import Vuex from 'vuex'

export const ROOT_KEY = '__root__'

var merge = require('lodash/merge')
var clone = require('lodash/clone')

/*
export const getModuleMockedStoreOptions = (state, mutations, getter, actions, namespace) => {
    const ns = Object.keys(namespace)[0]

    let options = {
        state: state || {},
        mutations: getMockedMutations(mutations, ns)
    }
    if (namespace[ns]) {
        options.namespaced = true
    }
    return options
}

const getObjectProperty = (obj, namespace, defaultValue) => {
    return 'object' === typeof obj && obj.hasOwnProperty(namespace)
        ? obj[namespace]
        : defaultValue
}

export const getMockedStoreOptions = (state, mutations, getter, actions, modules) => {
    const rootState = getObjectProperty(state, ROOT_KEY, default_root_state)

    let options = {
        state: rootState
    }
    if (modules) {
        let mockedModules = {}
        for (let namespace in modules) {
            let ns = {}
            ns[namespace] = modules[namespace]
            mockedModules[namespace] = getModuleMockedStoreOptions(
                getObjectProperty(state, namespace, {}),
                getObjectProperty(mutations, namespace, {}),
                getObjectProperty(getter, namespace, {}),
                getObjectProperty(actions, namespace, {}),
            )
        }
        options.modules = mockedModules
    }
    return options
}

export const getMockedStore = (state, mutations, getter, actions, modules) => {
    return new Vuex.Store(getMockedStoreOptions(state, mutations, getter, actions));

}

const mergeObject = (source, mocked, dest) => {
    for (let key in source) {
        if ('string' === typeof source[key]) {
            dest[key] = mocked.hasOwnProperty(key) ? mocked[key] : jest.fn()
        } else {
            dest[key] = copyMutation(source[key], mocked.hasOwnProperty(key) ? mocked[key] : {}, {})
        }
    }
    return dest
}

export const getMockedMutations = (mockedMutations, namespace) => {
    let mutations = namespace ? STORE[namespace].MUTATIONS : STORE.MUTATIONS
    return copyMutation(mutations, mockedMutations, {})
}*/

/*
const getObjProp = (obj, prop, defaultValue) => {
    return 'object' === typeof obj && obj.hasOwnProperty(prop)
        ? obj[prop]
        : defaultValue
}

export const getMockedStoreOptions = (mokedOptions) => {
    const rootState = merge(clone(store.state), clone(getObjProp(mokedOptions, 'state', {})))
    let options = {
        state: rootState
    }

}

export const getMockedStore = (mokedOptions, modules) => {
    return new Vuex.Store(getMockedStoreOptions(mokedOptions));

}*/