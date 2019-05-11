<template>
    <v-layout
        row
        wrap
        :class="{ valid: isValid }"
    >
        <slot />
    </v-layout>
</template>

<script>
export default {
    name: 'PredicateRowLayout',
    props: {
        isValid: {
            type: Boolean,
            required: true
        }
    }
};
</script>

<style scoped>
    .valid {
        background-color: #E3F2FD; /*blue lighten-5*/
    }
</style>
