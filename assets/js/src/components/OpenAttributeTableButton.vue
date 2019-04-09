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
                @click="$router.push(`/${prefix}/${table}/${action}#data-table`)"
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
        prefix: {
            type: String,
            default: 'data'
        },
        table: {
            type: String,
            required: true
        },
        action: {
            type: String,
            default: 'list'
        }
    }
};
</script>

<style scoped>

</style>
