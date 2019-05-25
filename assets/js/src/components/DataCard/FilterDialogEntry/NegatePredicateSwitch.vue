<template>
    <v-switch
        ref="switch"
        :input-value="value"
        label="Not"
        @change="emitChangeValue"
    />
</template>

<script>
export default {
    name: 'NegatePredicateSwitch',
    props: {
        value: {
            type: Boolean,
            required: true
        }
    },
    methods: {
        emitChangeValue(value) {
            this.$emit('update:value', value);
        }
    }
};
</script>
