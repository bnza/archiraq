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
                @click="openAttributeTable"
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
    },
    methods: {
        openAttributeTable() {
            const path = `/map/${this.prefix}/${this.table}/${this.action}#data-table`;

            const pattern = new RegExp('^'+path);
            if (this.$route.fullPath.match(pattern)) {
                document.getElementById('data-table').scrollIntoView({behavior: 'smooth'});
            } else {
                this.$router.push(path);
            }

        }
    }
};
</script>

<style scoped>

</style>
