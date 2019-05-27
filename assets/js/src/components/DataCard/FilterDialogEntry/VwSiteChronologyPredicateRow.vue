<template>
    <string-multiple-predicate-row
        ref="predicate"
        :predicate-p="predicateP"
        :predicate-key="predicateKey"
        predicate-attribute-label="Chronology"
        @change="$emit('change', $event)"
    >
        <v-select
            ref="select"
            slot="select"
            menu-props="{attach: true}"
            v-model="value"
            :items="chronologies"
            item-text="name"
            item-value="code"
            multiple
            @input="setPredicateExpression"
        />
    </string-multiple-predicate-row>
</template>

<script>
import NestedSlotPredicateMx from '@/mixins/CQL/NestedSlotPredicateMx';
import StringMultiplePredicateRow from '@/components/DataCard/FilterDialogEntry/StringMultiplePredicateRow';
export default {
    name: 'VwSiteChronologyPredicateRow',
    components: {
        StringMultiplePredicateRow
    },
    mixins: [
        NestedSlotPredicateMx
    ],
    computed: {
        chronologies() {
            return this.$store.state.vocabulary.chronologies;
        }
    },
};
</script>

<style scoped>

</style>
