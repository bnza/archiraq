<template>
    <v-text-field
        :value="predicateAttributeLabel"
        label="Attribute"
        readonly
    />
</template>

<script>
export default {
    name: 'AttributeTextField',
    props: {
        predicateAttributeLabel: {
            type: String,
            required: true
        }
    }
};
</script>
