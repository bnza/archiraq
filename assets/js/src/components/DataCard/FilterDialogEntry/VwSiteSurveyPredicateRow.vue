<template>
    <predicate-row-layout
        :is-valid="isPredicateValid"
    >
        <v-flex xs1>
            <negate-predicate-switch
                :value.sync="predicate.negate"
            />
        </v-flex>
        <v-flex xs3>
            <attribute-text-field
                :predicate-attribute-label="predicateAttributeLabel"
            />
        </v-flex>
        <v-flex xs2>
            <v-text-field
                value="="
                label="Operator"
                readonly
            />
        </v-flex>
        <v-flex xs3>
            <v-autocomplete
                ref="select"
                slot="select"
                label="Code"
                :value="predicate.expressions[1]"
                :attach="true"
                :items="surveys"
                :search-input.sync="search"
                @input="setPredicateExpression"
            />
        </v-flex>
        <v-flex xs3>
            <string-literal-text-field
                label="Reference"
                :value="predicate.expressions[2]"
                @update:value="setPredicateExpression($event,2)"
            />
        </v-flex>
    </predicate-row-layout>
</template>

<script>
import HttpClientMx from '@/mixins/HttpClientMx';
import PredicateMx from '@/mixins/CQL/PredicateMx';
import PredicateRowLayout from '@/components/DataCard/FilterDialogEntry/PredicateRowLayout';
import AttributeTextField from '@/components/DataCard/FilterDialogEntry/AttributeTextField';
import NegatePredicateSwitch from '@/components/DataCard/FilterDialogEntry/NegatePredicateSwitch';
import StringLiteralTextField from '@/components/DataCard/FilterDialogEntry/StringLiteralTextField';

export default {
    name: 'VwSiteSurveyPredicateRow',
    components: {
        PredicateRowLayout,
        AttributeTextField,
        NegatePredicateSwitch,
        StringLiteralTextField
    },
    mixins: [
        HttpClientMx,
        PredicateMx
    ],
    data() {
        return {
            surveys: [],
            search: ''
        };
    },
    watch: {
        search(pattern) {
            this.fetchSurveys(pattern);
        }
    },
    created() {
        this.setPredicateOperator(this.predicate.operator);
    },
    methods: {
        fetchSurveys(pattern) {
            return this.clientRequest({
                method:'get',
                url: `/data/voc-survey/codes/${pattern}`
            }).then(
                response => this.surveys = response.data
            );
        }
    }
};
</script>

<style scoped>

</style>
