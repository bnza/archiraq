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
            <v-text-field
                value="="
                label="Operator"
                readonly
            />
        </v-flex>
        <v-flex xs4>
            <slot name="select" />
        </v-flex>
    </predicate-row-layout>
</template>

<script>
import PredicateRowLayout from './PredicateRowLayout';
import AttributeTextField from './AttributeTextField';
import NegatePredicateSwitch from './NegatePredicateSwitch';
import PredicateMx from '@/mixins/CQL/PredicateMx';

export default {
    name: 'StringMultiplePredicateRow',
    components: {
        PredicateRowLayout,
        AttributeTextField,
        NegatePredicateSwitch
    },
    mixins: [
        PredicateMx
    ],
    created() {
        this.setPredicateOperator(this.predicate.operator);
    },
};
</script>
