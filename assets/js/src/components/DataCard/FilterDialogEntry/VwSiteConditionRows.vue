<template>
    <div>
        <string-predicate-row
            :predicate-p="conditions.modernName"
            predicate-key="modernName"
            predicate-attribute-label="Modern Name"
            @change="setCondition"
        />
        <vw-site-district-predicate-row
            :predicate-p="conditions.district"
            predicate-key="district"
            @change="setCondition"
        />
    </div>
</template>

<script>
import StringPredicateRow from '@/components/DataCard/FilterDialogEntry/StringPredicateRow';
import VwSiteDistrictPredicateRow from '@/components/DataCard/FilterDialogEntry/VwSiteDistrictPredicateRow';
import ConditionMx from '@/mixins/CQL/ConditionMx';
import QueryMx from '@/mixins/QueryMx';
import {QUERY_TYPENAME_VW_SITES} from '@/utils/cids';


const defaultConditions = () => {
    return {
        district: {
            negate: false,
            expressions: ['district', []],
            operator: 'MultipleEqualToFilter'
        },
        modernName: {
            negate: false,
            expressions: ['modern_name'],
            operator: ''
        }
    };
};

export default {
    name: 'VwSiteDataCardRow',
    components: {
        VwSiteDistrictPredicateRow,
        StringPredicateRow,
    },
    mixins: [
        QueryMx,
        ConditionMx
    ],
    created() {
        // Retrieve from store
        let conditions = Object.assign(defaultConditions(), this.getQueryConditions(QUERY_TYPENAME_VW_SITES));
        this.conditions = conditions;
    },
    methods: {
        getQueryTypeName() {
            return QUERY_TYPENAME_VW_SITES;
        },
        submit() {
            this.setQueryConditions(this.conditions);
            this.setQueryFilter(this.getAndConditionsFilter());
        },
        clear() {
            this.conditions = defaultConditions();
            this.setQueryConditions(this.conditions);
            this.setQueryFilter(null);
        }
    }
};
</script>
