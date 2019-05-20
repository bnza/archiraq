<template>
    <string-multiple-predicate-row
        ref="predicate"
        :predicate-p="predicateP"
        :predicate-key="predicateKey"
        predicate-attribute-name="district"
        predicate-attribute-label="District"
        @change="$emit('change', $event)"
    >
        <v-select
            slot="select"
            v-model="value"
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
        predicateP: {
            type: Object,
            default: () => {}
        },
        predicateKey: {
            type: String,
            required: true
        },
    },
    data() {
        return {
            value: []
        };
    },
    computed: {
        districts() {
            return this.$store.state.vocabulary.districts;
        }
    },
    watch: {
        predicateP: {
            handler(predicate) {
                this.value = predicate.expressions[1];
            },
            deep: true
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
