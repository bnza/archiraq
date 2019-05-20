<template>
    <v-text-field
        v-if="value"
        readonly
        :label="label"
        :value="value"
    />
</template>

<script>
export default {
    name: 'PopupTextField',
    props: {
        label: {
            type: String,
            required: true
        },
        value: {
            type: String,
            default: ''
        }
    }
};
</script>

<style scoped>
    .v-text-field {
        padding-top: 0;
    }
    /deep/ .v-text-field__slot input {
        font-size: 12px;
        padding: 0;
    }
    /deep/ .v-label {
        font-size: 0.8rem;
    }
</style>
