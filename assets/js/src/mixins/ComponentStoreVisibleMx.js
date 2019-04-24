import ComponentsStoreMx from './ComponentsStoreMx';

export default {
    mixins: [
        ComponentsStoreMx
    ],
    props: {
        visibleP: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        visible: {
            get() {
                return !!this.cid && this.getProp('visible');
            },
            set(value) {
                this.setProp('visible', value);
            }
        }
    },
    methods: {
        /**
         * Syncs visible value committing it to $store.
         * Needed when changes is triggered outside store changes e.g. open/closing TheMainNavigationDrawer
         * @param {boolean} event
         */
        syncVisible(event) {
            if (event !== this.visible) {
                this.visible = event;
            }
        }
    },
    created() {
        this.visible = this.visibleP;
    }
};
