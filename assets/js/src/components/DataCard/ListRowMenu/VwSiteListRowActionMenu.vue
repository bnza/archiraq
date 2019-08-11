<template>
    <list-row-actions-menu>
        <v-list>
            <v-list-tile @click="zoomToItemFeature">
                <v-list-tile-action>
                    <v-icon>place</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Zoom to feature</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
    </list-row-actions-menu>
</template>

<script>
import MapContainerComponentStoreMx from '@/mixins/MapContainerComponentStoreMx';
import ListRowActionsMenu from './ListRowActionsMenu';
export default {
    name: 'VwSiteListRowActionMenu',
    components: {
        ListRowActionsMenu
    },
    mixins: [
        MapContainerComponentStoreMx
    ],
    props: {
        item: {
            type: Object,
            default: function () {
                return {};
            }
        }
    },
    methods: {
        zoomToItemFeature() {
            this.mapContainerCallMethod('zoomToItemGeometry', this.item);
            this.$vuetify.goTo('#map');
        }
    }
};
</script>

<style scoped>

</style>
