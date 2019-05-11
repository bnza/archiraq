<template>
    <predicate-row-layout
        :is-valid="isPredicateValid"
    >
        <v-flex xs1>
            <negate-predicate-switch
                @change="setNegatePredicate"
            />
        </v-flex>
        <v-flex xs3>
            <attribute-text-field
                :predicate-attribute-label="predicateAttributeLabel"
            />
        </v-flex>

        <v-flex xs4>
            <string-operator-select-input
                @input="setPredicateOperator"
            />
        </v-flex>
        <v-flex xs4>
            <string-literal-text-field
                @input="setPredicateExpression"
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
import BinaryPredicateMx from '@/mixins/CQL/BinaryPredicateMx';

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
        BinaryPredicateMx
    ]
};
</script>
