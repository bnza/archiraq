import {mapGetters, mapMutations} from 'vuex';
import {HAS_COMPONENT, GET_COMPONENT_PROP} from '../store/components/getters';
import {CREATE_COMPONENT, SET_COMPONENT_PROP, TOGGLE_COMPONENT_PROP} from '../store/components/mutations';


export default {
    data() {
        return {
            cid: ''
        };
    },
    props: {
        cidP: {
            type: String,
            validator: (value) => {
                return /^[\w]+$/.test(value);
            }
        }
    },
    computed: {
        ...mapGetters('components', [
            HAS_COMPONENT,
            GET_COMPONENT_PROP
        ]),
    },
    methods: {
        ...mapMutations('components', [
            CREATE_COMPONENT,
            SET_COMPONENT_PROP,
            TOGGLE_COMPONENT_PROP
        ]),
        getProp(prop) {
            return this[GET_COMPONENT_PROP](this.cid, prop);
        },
        setProp(prop, value) {
            this[SET_COMPONENT_PROP]({
                cid: this.cid,
                prop: prop,
                value: value
            });
        },
        toggleProp(prop) {
            this[TOGGLE_COMPONENT_PROP]({
                cid: this.cid,
                prop: prop
            });
        }
    },
    created() {
        if (this.cidP) {
            this.cid = this.cidP;
        }
        if (
            this.cid
            && !this[HAS_COMPONENT](this.cid)
        ) {
            this[CREATE_COMPONENT]({cid: this.cid});
        }
    }
};
