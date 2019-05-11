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
            <v-text-field
                value="="
                label="Operator"
                readonly
            />
        </v-flex>
        <v-flex xs4>
            <slot name="select" />
        </v-flex>
    </v-layout>
</template>

<script>
import AttributeTextField from './AttributeTextField';
import NegatePredicateSwitch from './NegatePredicateSwitch';
import BinaryPredicateMx from '@/mixins/CQL/BinaryPredicateMx';

export default {
    name: 'StringMultiplePredicateRow',
    components: {
        AttributeTextField,
        NegatePredicateSwitch
    },
    mixins: [
        BinaryPredicateMx
    ],
    created() {
        this.setPredicateOperator('MultipleEqualToFilter');
    }
};
</script>
