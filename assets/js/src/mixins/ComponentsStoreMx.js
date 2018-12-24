import STORE from '../store/store-funcs'
import {mapGetters, mapMutations} from 'vuex'

const NAMESPACE = 'components'

export default {
    data() {
        return {
            $_ComponentStoreMx_cid: ''
        }
    },
    props: {
        cidP: {
            type: String,
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
        if (this.cidP) {
            this.$data.$_ComponentStoreMx_cid = this.cidP
        }
        if (this.$data.$_ComponentStoreMx_cid) {
            this[STORE.COMPONENTS.MUTATIONS.CREATE](this.$data.$_ComponentStoreMx_cid)
        }
    },
    methods: {
        ...mapMutations(NAMESPACE, [
            STORE.COMPONENTS.MUTATIONS.CREATE,
            STORE.COMPONENTS.MUTATIONS.PROP.SET,
            STORE.COMPONENTS.MUTATIONS.PROP.TOGGLE
        ]),
        $_ComponentStoreMx_getStoreProp(prop) {
            return this[STORE.COMPONENTS.GETTERS.PROP.GET](this.$data.$_ComponentStoreMx_cid, prop)
        },
        $_ComponentStoreMx_setStoreProp(prop, value) {
            this[STORE.COMPONENTS.MUTATIONS.PROP.SET]({
                cid: this.$data.$_ComponentStoreMx_cid,
                prop: prop,
                value: value
            })
        },
        $_ComponentStoreMx_toggleStoreProp(prop) {
            this[STORE.COMPONENTS.MUTATIONS.PROP.TOGGLE]({
                cid: this.$data.$_ComponentStoreMx_cid,
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