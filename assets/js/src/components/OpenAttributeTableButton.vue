<template>
    <v-tooltip
        slot="activator"
        bottom
    >
        <template slot="activator">
            <v-btn
                color="primary"
                icon
                flat
            >
                <v-icon>list</v-icon>
            </v-btn>
        </template>
        <span>Open attribute table</span>
    </v-tooltip>
</template>

<script>
export default {
    name: 'OpenAttributeTableButton',
    props: {
        table: {
            type: String,
            required: true
        }
    }
};
</script>

<style scoped>

</style>
