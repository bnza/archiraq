<template>
    <v-text-field
        ref="field"
        v-model="value"
        label="Value"
        clearable
        @input="emitInputValue"
    />
</template>

<script>
export default {
    name: 'StringLiteralTextField',
    data() {
        return {
            value: ''
        };
    },
    methods: {
        emitInputValue(value) {
            this.$emit('input', value);
        }
    }
};
</script>
