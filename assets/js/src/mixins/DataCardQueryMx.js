import QueryMx from '@/mixins/QueryMx';

export default {
    mixins: [
        QueryMx
    ],
    props: {
        queryTypename  : {
            type: String,
            required: true
        },
    },
    computed: {
        pagination: {
            get() {
                return this.getPagination(this.queryTypename);
            },
            set(pagination) {
                this.setPagination({typename: this.queryTypename, pagination: pagination});
            }
        },
        filter: {
            get() {
                return this.getQueryFilter(this.queryTypename);
            },
            set(filter) {
                this.setQueryFilter(filter);
            }
        }
    },
};
