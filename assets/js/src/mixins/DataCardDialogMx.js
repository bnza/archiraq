export default {
    props: {
        visible: {
            type: Boolean,
            required: true
        },
        isRequestPending: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        isDialogActive: {
            get() {
                return this.visible;
            },
            set(value) {
                this.$emit('update:visible', value);
            }
        }
    }
};
