import DataCardQueryMx from './DataCardQueryMx';

export default {
    mixins: [
        DataCardQueryMx
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
        headers: {
            type: Array,
            default() {
                return [];
            }
        },
        isRequestPending: {
            type: Boolean,
            default: false
        }
    },

};
