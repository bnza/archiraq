import {cloneDeep} from 'lodash';

export default {
    props: {
        item: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            localItem: null,
        };
    },
    mounted() {
        this.localItem = cloneDeep(this.item);
    },
    methods: {
        doChange()
        {
            this.$emit('change', this.localItem);
            this.$emit('close');
        }
    }
};
