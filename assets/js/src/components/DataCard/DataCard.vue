<template>
    <v-card class="card--flex-toolbar">
        <v-toolbar
            dense
            flat
            :color="color"
            :dark="dark"
            :height="height"
        >
            <slot name="toolbar" />
        </v-toolbar>
        <v-card-text :class="{'no-padding': !padding}">
            <slot name="data" />
        </v-card-text>
        <v-card-actions>
            <slot name="actions" />
        </v-card-actions>
        <slot name="modal" />
    </v-card>
</template>

<script>
export default {
    name: 'DataCard',
    props: {
        color: {
            type: String,
            default: 'green lighten-4'
        },
        height: {
            type: Number,
            default: undefined
        },
        dark: {
            type: Boolean,
            default: false
        },
        padding: {
            type: Boolean,
            default: false
        }
    }
};
</script>

<style scoped>
    .no-padding {
        padding: 0
    }
</style>
