import Vue from 'vue'
import Vuex from 'vuex'
import components from './components'

Vue.use(Vuex)

export const state = {}

export const getters = {}

export default new Vuex.Store(
    {
        strict: process.env.NODE_ENV !== 'production',
        state,
        getters,
        modules: {
            components: components
        }
    }
)