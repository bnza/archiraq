import STORE from '../store/store-funcs';
import {mapGetters, mapMutations} from 'vuex';

const NAMESPACE = 'components';

export default {
    data() {
        return {
            componentStoreMx_cid: ''
        };
    },
    props: {
        cidP: {
            type: String,
            validator: (value) => {
                return /^[\w-]+$/.test(value);
            }
        }
    },
    computed: {
        ...mapGetters(NAMESPACE, [
            STORE.COMPONENTS.GETTERS.PROP.GET
        ]),
        componentStoreMx_STORE() {
            return STORE;
        }
    },
    created() {
        if (this.cidP) {
            this.$data.componentStoreMx_cid = this.cidP;
        }
        if (this.$data.componentStoreMx_cid) {
            this[STORE.COMPONENTS.MUTATIONS.CREATE](this.$data.componentStoreMx_cid);
        }
    },
    methods: {
        ...mapMutations(NAMESPACE, [
            STORE.COMPONENTS.MUTATIONS.CREATE,
            STORE.COMPONENTS.MUTATIONS.PROP.SET,
            STORE.COMPONENTS.MUTATIONS.PROP.TOGGLE
        ]),
        componentStoreMx_getStoreProp(prop) {
            return this[STORE.COMPONENTS.GETTERS.PROP.GET](this.$data.componentStoreMx_cid, prop);
        },
        componentStoreMx_setStoreProp(prop, value) {
            this[STORE.COMPONENTS.MUTATIONS.PROP.SET]({
                cid: this.$data.componentStoreMx_cid,
                prop: prop,
                value: value
            });
        },
        componentStoreMx_toggleStoreProp(prop) {
            this[STORE.COMPONENTS.MUTATIONS.PROP.TOGGLE]({
                cid: this.$data.componentStoreMx_cid,
                prop: prop
            });
        },
        componentStoreMx_getter(name) {
            return this[name];
        },
        componentStoreMx_mutation(name, payload) {
            this[name](payload);
        }
    }
};