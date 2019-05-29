<template>
    <list-row-actions-menu
        tooltip-text="Menu"
    >
        <v-list data-test="vw-site-table--action-menu">
            <v-list-tile
                @click="$emit('openModal', 'filter')"
            >
                <v-list-tile-action>
                    <v-icon>
                        filter_list
                    </v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Filter features</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
                v-if="authIsAuthenticated"
                @click="$emit('openModal', 'export')"
            >
                <v-list-tile-action>
                    <v-icon>
                        get_app
                    </v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Export features</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
                @click="$emit('zoomToLayer')"
            >
                <v-list-tile-action>
                    <v-icon>
                        zoom_out_map
                    </v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Zoom to layer</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
    </list-row-actions-menu>
</template>

<script>
import ListRowActionsMenu from './ListRowActionsMenu';
import AuthMx from '@/mixins/AuthMx';

export default {
    name: 'VwSiteTableActionMenu',
    components: {
        ListRowActionsMenu
    },
    mixins: [
        AuthMx
    ],
};
</script>

<style scoped>

</style>
