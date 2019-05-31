<template>
    <list-row-actions-menu
        :dark="false"
        icon="more_vert"
        tooltip-text="Actions"
    >
        <v-list data-test="vw-site-layer--action-menu">
            <v-list-tile
                data-test="openAttributeTable"
                @click="openAttributeTable({table: 'vw-site'})"
            >
                <v-list-tile-action>
                    <v-icon>
                        list
                    </v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Open attribute table</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
    </list-row-actions-menu>
</template>

<script>
import OpenAttributeTableMx from '@/mixins/OpenAttributeTableMx';
import ListRowActionsMenu from './ListRowActionsMenu';
export default {
    name: 'WvSiteLayerActionMenu',
    components: {
        ListRowActionsMenu
    },
    mixins: [
        OpenAttributeTableMx
    ]
};
</script>

<style scoped>

</style>
