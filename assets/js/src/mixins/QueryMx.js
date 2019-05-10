import {mapGetters, mapMutations} from 'vuex';
import {GET_PAGINATION, GET_FILTER} from '../store/query/getters';
import {SET_PAGINATION, SET_FILTER} from '../store/query/mutations';

export default {
    computed: {
        ...mapGetters({
            getPagination: `query/${GET_PAGINATION}`,
            getQueryFilter: `query/${GET_FILTER}`
        }),
    },
    methods: {
        ...mapMutations({
            setPagination: `query/${SET_PAGINATION}`,
            setQueryFilter: `query/${SET_FILTER}`
        })
    }
};
