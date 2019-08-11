import DataCardTableRowMx from './DataCardTableRowMx';

export default {
    mixins: [
        DataCardTableRowMx
    ],
    props: {
        totalItems: {
            type: Number,
            default: 0
        },
        items: {
            type: Array,
            default() {
                return [];
            }
        },
        isRequestPending: {
            type: Boolean,
            default: false
        }
    }
};
