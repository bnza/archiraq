<template>
    <string-multiple-predicate-row
        ref="predicate"
        :predicate-p="predicateP"
        :predicate-key="predicateKey"
        predicate-attribute-label="District"
        @change="$emit('change', $event)"
    >
        <v-select
            ref="select"
            slot="select"
            v-model="value"
            :items="districts"
            item-text="name"
            item-value="name"
            multiple
            attach
            @input="setPredicateExpression"
        />
    </string-multiple-predicate-row>
</template>

<script>
import NestedSlotPredicateMx from '@/mixins/CQL/NestedSlotPredicateMx';
import StringMultiplePredicateRow from '@/components/DataCard/FilterDialogEntry/StringMultiplePredicateRow';
export default {
    name: 'VwSiteDistrictPredicateRow',
    components: {
        StringMultiplePredicateRow
    },
    mixins: [
        NestedSlotPredicateMx
    ],
    computed: {
        districts() {
            return this.$store.state.vocabulary.districts;
        }
    },
};
</script>

<style scoped>

</style>
