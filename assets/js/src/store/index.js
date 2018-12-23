import Vue from 'vue'
import Vuex from 'vuex'
import mutations from './mutations'
import components from './components'

Vue.use(Vuex)

export const state = {
    bingApiKey: '',
    default: {
        baseMap: 'bing',
        bingImagerySet: 'AerialWithLabels'
    }
}

export const getters = {}

export default new Vuex.Store(
    {
        strict: process.env.NODE_ENV !== 'production',
        state,
        mutations,
        getters,
        modules: {
            components: components
        }
    }
)