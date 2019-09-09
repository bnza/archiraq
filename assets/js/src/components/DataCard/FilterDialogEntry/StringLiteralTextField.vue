<template>
    <v-text-field
        ref="field"
        :value="value"
        :label="label"
        clearable
        @input="emitInputValue"
    />
</template>

<script>
export default {
    name: 'StringLiteralTextField',
    props: {
        label: {
            type: String,
            default: 'Value'
        },
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
