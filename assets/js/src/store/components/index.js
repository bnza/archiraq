import getters from './getters'
import mutations from './mutations'
export const state = {
    all: {}
}

export default {
    namespaced: true,
    state,
    getters,
    mutations
}