import QueryMx from '@/mixins/QueryMx';

export default {
    mixins: [
        QueryMx
    ],
    props: {
        typename  : {
            type: String,
            required: true
        },
    },
    computed: {
        pagination: {
            get() {
                return this.getPagination(this.typename);
            },
            set(pagination) {
                this.setPagination({typename: this.typename, pagination: pagination});
            }
        },
        filter: {
            get() {
                return this.getQueryFilter(this.typename);
            },
            set(filter) {
                this.setQueryFilter({typename: this.typename, filter: filter});
            }
        }
    },
};
