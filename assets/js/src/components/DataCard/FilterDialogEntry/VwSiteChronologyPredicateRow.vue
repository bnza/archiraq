<template>
    <string-multiple-predicate-row
        ref="predicate"
        :predicate-p="predicateP"
        :predicate-key="predicateKey"
        predicate-attribute-label="Chronology"
        @change="$emit('change', $event)"
    >
        <v-autocomplete
            ref="select"
            slot="select"
            v-model="value"
            menu-props="{attach: true}"
            :items="chronologies"
            item-text="name"
            item-value="code"
            multiple
            @input="setPredicateExpression"
            @keydown.enter="$refs.select.menuIsActive = false"
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
