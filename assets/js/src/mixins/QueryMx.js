import {mapGetters, mapMutations} from 'vuex';
import {GET_CONDITIONS, GET_FILTER, GET_PAGINATION} from '@/store/query/getters';
import {SET_CONDITIONS, SET_FILTER, SET_PAGINATION} from '@/store/query/mutations';

export default {
    computed: {
        ...mapGetters({
            getQueryConditions: `query/${GET_CONDITIONS}`,
            getQueryFilter: `query/${GET_FILTER}`,
            getPagination: `query/${GET_PAGINATION}`
        }),
    },
    methods: {
        getQueryTypeName() {
            throw new Error(`You must override "QueryMax::getQueryTypeName" method in component "${this.$options.name}"`);
        },
        setQueryConditions(conditions) {
            this.setQueryConditionsFn({
                typename: this.getQueryTypeName(),
                conditions
            });
        },
        setQueryFilter(filter) {
            this.setQueryFilterFn({
                typename: this.getQueryTypeName(),
                filter
            });
        },
        ...mapMutations({
            setQueryConditionsFn: `query/${SET_CONDITIONS}`,
            setQueryFilterFn: `query/${SET_FILTER}`,
            setPagination: `query/${SET_PAGINATION}`
        })
    }
};
