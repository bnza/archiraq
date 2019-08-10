<template>
    <div data-test="vw-site-table--condition-rows">
        <string-predicate-row
            data-test="modernName"
            :predicate-p="conditions.modernName"
            predicate-key="modernName"
            predicate-attribute-label="Modern Name"
            @change="setCondition"
        />
        <vw-site-district-predicate-row
            data-test="district"
            :predicate-p="conditions.district"
            predicate-key="district"
            @change="setCondition"
        />
        <vw-site-chronology-predicate-row
            data-test="chronology"
            :predicate-p="conditions.chronology"
            predicate-key="chronology"
            @change="setCondition"
        />
    </div>
</template>

<script>
import StringPredicateRow from '@/components/DataCard/FilterDialogEntry/StringPredicateRow';
import VwSiteChronologyPredicateRow from '@/components/DataCard/FilterDialogEntry/VwSiteChronologyPredicateRow';
import VwSiteDistrictPredicateRow from '@/components/DataCard/FilterDialogEntry/VwSiteDistrictPredicateRow';
import ConditionMx from '@/mixins/CQL/ConditionMx';
import QueryMx from '@/mixins/QueryMx';
import {QUERY_TYPENAME_VW_SITES} from '@/utils/cids';


const defaultConditions = () => {
    return {
        chronology: {
            negate: false,
            expressions: ['chronology', []],
            operator: 'MultipleIsInsensitiveLikeFilter'
        },
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
    name: 'VwSiteConditionRows',
    components: {
        VwSiteChronologyPredicateRow,
        VwSiteDistrictPredicateRow,
        StringPredicateRow,
    },
    mixins: [
        QueryMx,
        ConditionMx
    ],
    props: {
        modalProps: {
            type: Object,
            required: true,
            validator: function (value) {
                return value.hasOwnProperty('queryTypename');
            }
        }
    },
    computed: {
        queryTypename() {
            return this.modalProps.queryTypename;
        }
    },
    created() {
        // Retrieve from store
        let conditions = Object.assign(defaultConditions(), this.getQueryConditions(this.queryTypename));
        this.conditions = conditions;
    },
    methods: {
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
