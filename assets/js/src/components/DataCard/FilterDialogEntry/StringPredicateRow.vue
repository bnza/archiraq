<template>
    <v-layout
        row
        wrap
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
    </v-layout>
</template>

<script>
import AttributeTextField from './AttributeTextField';
import StringLiteralTextField from './StringLiteralTextField';
import StringOperatorSelectInput from './StringOperatorSelectInput';
import NegatePredicateSwitch from './NegatePredicateSwitch';
import BinaryPredicateMx from '@/mixins/CQL/BinaryPredicateMx';

export default {
    name: 'StringPredicateRow',
    components: {
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
