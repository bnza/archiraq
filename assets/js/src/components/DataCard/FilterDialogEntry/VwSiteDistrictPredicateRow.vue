<template>
    <string-multiple-predicate-row
        ref="predicate"
        :predicate-index="predicateIndex"
        predicate-attribute-name="district"
        predicate-attribute-label="District"
        @change="$emit('change', predicateIndex, arguments[1])"
    >
        <v-select
            slot="select"
            :items="districts"
            item-text="name"
            item-value="name"
            multiple
            @input="setPredicateExpression"
        />
    </string-multiple-predicate-row>
</template>

<script>
import StringMultiplePredicateRow from '@/components/DataCard/FilterDialogEntry/StringMultiplePredicateRow';
export default {
    name: 'VwSiteDistrictPredicateRow',
    components: {
        StringMultiplePredicateRow
    },
    props: {
        predicateIndex: {
            type: Number,
            required: true
        }
    },
    computed: {
        districts() {
            return this.$store.state.vocabulary.districts;
        }
    },
    methods: {
        setPredicateExpression($event) {
            this.$refs.predicate.setPredicateExpression($event);
        }
    }
};
</script>

<style scoped>

</style>
