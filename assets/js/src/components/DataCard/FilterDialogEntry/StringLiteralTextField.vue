<template>
    <v-text-field
        ref="field"
        :value="value"
        label="Value"
        clearable
        @input="emitInputValue"
    />
</template>

<script>
export default {
    name: 'StringLiteralTextField',
    props: {
        value: {
            type: String,
            default: ''
        }
    },
    methods: {
        emitInputValue(value) {
            this.$emit('update:value', value);
        }
    }
};
</script>
