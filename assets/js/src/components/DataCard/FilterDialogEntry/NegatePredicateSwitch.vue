<template>
    <v-switch
        ref="switch"
        v-model="value"
        label="Not"
        @change="emitChangeValue"
    />
</template>

<script>
export default {
    name: 'NegatePredicateSwitch',
    data() {
        return {
            value: false
        };
    },
    methods: {
        emitChangeValue(value) {
            this.$emit('change', value);
        }
    }
};
</script>
