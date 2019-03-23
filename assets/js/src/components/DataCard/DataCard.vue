<template>
    <v-card class="card--flex-toolbar">
        <v-toolbar
            dense
            flat
            color="green lighten-4"
        >
            <slot name="toolbar" />
        </v-toolbar>
        <v-card-text style="padding: 0">
            <slot name="data" />
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: 'DataCard'
};
</script>

<style scoped>

</style>
