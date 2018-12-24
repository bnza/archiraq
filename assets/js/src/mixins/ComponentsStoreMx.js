import STORE from '../store/store-funcs'
import {mapGetters, mapMutations} from 'vuex'

const NAMESPACE = 'components'

export default {
    props: {
        cidP: {
            type: String,
            required: true,
            validator: (value) => {
                return /^[\w-]+$/.test(value)
            }
        }
    },
    computed: {
        $_ComponentStoreMx_STORE() {
          return STORE
        },
        ...mapGetters(NAMESPACE, [
            STORE.COMPONENTS.GETTERS.PROP.GET
        ]),
    },
    created() {
        this[STORE.COMPONENTS.MUTATIONS.CREATE](this.cidP)
    },
    methods: {
        ...mapMutations(NAMESPACE, [
            STORE.COMPONENTS.MUTATIONS.CREATE,
            STORE.COMPONENTS.MUTATIONS.PROP.SET,
            STORE.COMPONENTS.MUTATIONS.PROP.TOGGLE
        ]),
        $_ComponentStoreMx_getStoreProp(prop) {
            return this[STORE.COMPONENTS.GETTERS.PROP.GET](this.cidP, prop)
        },
        $_ComponentStoreMx_setStoreProp(prop, value) {
            this[STORE.COMPONENTS.MUTATIONS.PROP.SET]({
                cid: this.cidP,
                prop: prop,
                value: value
            })
        },
        $_ComponentStoreMx_toggleStoreProp(prop) {
            this[STORE.COMPONENTS.MUTATIONS.PROP.TOGGLE]({
                cid: this.cidP,
                prop: prop
            })
        },
        $_ComponentStoreMx_getter(name) {
            return this[name]
        },
        $_ComponentStoreMx_mutation(name, payload) {
            this[name](payload)
        }
    }
}