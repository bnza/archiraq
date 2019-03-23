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
            default: []
        },
        headers: {
            type: Array,
            default: []
        }
    },

};
