<template>
    <div>
        <string-predicate-row
            :predicate-index="0"
            predicate-attribute-name="modern_name"
            predicate-attribute-label="Modern Name"
            @change="setCondition"
        />
    </div>
</template>

<script>
import StringPredicateRow from '@/components/DataCard/FilterDialogEntry/StringPredicateRow';
import ConditionMx from '@/mixins/CQL/ConditionMx';
import QueryMx from '@/mixins/QueryMx';

export default {
    name: 'VwSiteDataCardRow',
    components: {StringPredicateRow},
    mixins: [
        QueryMx,
        ConditionMx
    ],
    methods: {
        submit() {
            this.setQueryFilter({typename: 'vw-site', filter: this.getAndCondition()});
        },
        clear() {
            this.setQueryFilter({typename: 'vw-site', filter: null});
        }
    }
};
</script>
