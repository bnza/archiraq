//import STORE from '../store/store-funcs';
import {mapGetters, mapMutations} from 'vuex';
import {
    STORE_M_COMPONENTS_G_COMPONENT_PROP,
    STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP,
    STORE_M_COMPONENTS_M_CREATE_COMPONENT,
    STORE_M_COMPONENTS_M_COMPONENT_PROP
} from '../utils/constants';

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
            STORE_M_COMPONENTS_G_COMPONENT_PROP
        ]),
    },
    created() {
        if (this.cidP) {
            this.$data.componentStoreMx_cid = this.cidP;
        }
        if (
            this.$data.componentStoreMx_cid
            && !this.$store.state.components.all.hasOwnProperty(this.$data.componentStoreMx_cid)
        ) {
            this[STORE_M_COMPONENTS_M_CREATE_COMPONENT]({cid: this.$data.componentStoreMx_cid});
        }
    },
    methods: {
        ...mapMutations(NAMESPACE, [
            STORE_M_COMPONENTS_M_CREATE_COMPONENT,
            STORE_M_COMPONENTS_M_COMPONENT_PROP,
            STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP
        ]),
        componentStoreMx_getStoreProp(prop) {
            return this[STORE_M_COMPONENTS_G_COMPONENT_PROP](this.$data.componentStoreMx_cid, prop);
        },
        componentStoreMx_setStoreProp(prop, value) {
            this[STORE_M_COMPONENTS_M_COMPONENT_PROP]({
                cid: this.$data.componentStoreMx_cid,
                prop: prop,
                value: value
            });
        },
        componentStoreMx_toggleStoreProp(prop) {
            this[STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP]({
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
