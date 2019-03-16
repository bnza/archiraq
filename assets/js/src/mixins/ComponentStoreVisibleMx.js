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
    created() {
        this.visible = this.visibleP;
    }
};
