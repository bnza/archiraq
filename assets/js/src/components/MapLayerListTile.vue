<template>
    <v-list-tile>
        <v-list-tile-action>
            <v-list-tile-action>
                <slot name="visibility" />
            </v-list-tile-action>
        </v-list-tile-action>
        <v-list-tile-content>
            <v-list-tile-title>{{ title }}</v-list-tile-title>
        </v-list-tile-content>
        <v-list-tile-action v-if="$slots.action">
            <v-menu offset-y>
                <v-tooltip
                    slot="activator"
                    bottom
                >
                    <v-btn
                        slot="activator"
                        color="primary"
                        icon
                        flat
                    >
                        <v-icon>more_vert</v-icon>
                    </v-btn>
                    <span>Settings</span>
                </v-tooltip>
                <slot name="action" />
            </v-menu>
        </v-list-tile-action>
    </v-list-tile>
</template>

<script>
export default {
    name: 'MapLayerListTile',
    props: {
        title: {
            type: String,
            required: true
        }
    }
};
</script>

<style scoped>

</style>