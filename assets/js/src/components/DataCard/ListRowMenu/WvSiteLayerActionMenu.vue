<template>
    <list-row-actions-menu
        :dark="false"
        icon="more_vert"
        tooltip-text="Actions"
    >
        <v-list data-test="vw-site-layer--action-menu">
            <v-list-tile
                data-test="zoomToLayer"
                @click="$emit('zoomToLayer', typename)"
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
            <v-list-tile
                data-test="openAttributeTable"
                @click="openAttributeTable({table: table})"
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
import {kebabCase} from 'lodash';
import OpenAttributeTableMx from '@/mixins/OpenAttributeTableMx';
import ListRowActionsMenu from './ListRowActionsMenu';
export default {
    name: 'WvSiteLayerActionMenu',
    components: {
        ListRowActionsMenu
    },
    mixins: [
        OpenAttributeTableMx
    ],
    props: {
        typename: {
            type: String,
            required: true
        }
    },
    computed: {
        table() {
            return kebabCase(this.typename);
        }
    }
};
</script>

<style scoped>

</style>
