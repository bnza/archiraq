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
        <v-flex xs4>
            <string-operator-select-input
                :value.sync="predicate.operator"
            />
        </v-flex>
        <v-flex xs4>
            <string-literal-text-field
                :value="predicate.expressions[1]"
                @update:value="setPredicateExpression"
            />
        </v-flex>
    </predicate-row-layout>
</template>

<script>
import PredicateRowLayout from './PredicateRowLayout';
import AttributeTextField from './AttributeTextField';
import StringLiteralTextField from './StringLiteralTextField';
import StringOperatorSelectInput from './StringOperatorSelectInput';
import NegatePredicateSwitch from './NegatePredicateSwitch';
import PredicateMx from '@/mixins/CQL/PredicateMx';

export default {
    name: 'StringPredicateRow',
    components: {
        PredicateRowLayout,
        AttributeTextField,
        NegatePredicateSwitch,
        StringLiteralTextField,
        StringOperatorSelectInput
    },
    mixins: [
        PredicateMx
    ]
};
</script>
