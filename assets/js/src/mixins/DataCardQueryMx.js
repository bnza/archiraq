import {mapGetters, mapMutations} from 'vuex';
import {GET_PAGINATION} from '../store/query/getters';
import {SET_PAGINATION} from '../store/query/mutations';

export default {
    props: {
        typename  : {
            type: String,
            required: true
        },
    },
    computed: {
        ...mapGetters({
            getPagination: `query/${GET_PAGINATION}`
        }),
        pagination: {
            get() {
                return this.getPagination(this.typename);
            },
            set(pagination) {
                this.setPagination({typename: this.typename, pagination: pagination});
            }
        }
    },
    methods: {
        ...mapMutations({
            setPagination: `query/${SET_PAGINATION}`
        })
    }
};
