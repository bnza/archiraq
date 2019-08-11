import DataCardQueryMx from './DataCardQueryMx';

export default {
    mixins: [
        DataCardQueryMx
    ],
    props: {
        headers: {
            type: Array,
            default() {
                return [];
            }
        },
    },
    methods: {
        headersHaveElement(value) {
            return undefined !== this.headers.find((element) => {
                return element.value === value;
            });
        }
    }
};
