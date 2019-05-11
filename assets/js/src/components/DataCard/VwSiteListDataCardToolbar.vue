<template>
    <v-fragment>
        <vw-site-table-action-menu
            @openModal="$emit('openModal', $event)"
            @zoomToLayer="zoomToLayer"
        />

        <v-toolbar-title>Site</v-toolbar-title>
    </v-fragment>
</template>

<script>
import {Fragment as VFragment} from 'vue-fragment';
import VwSiteTableActionMenu from './ListRowMenu/VwSiteTableActionMenu';
import MapContainerComponentStoreMx from '@/mixins/MapContainerComponentStoreMx';
import {CID_MAP_LAYER_VECTOR_WFS_VW_SITES} from '@/utils/cids';

export default {
    name: 'VwSiteDataCardToolbar',
    components: {
        VFragment,
        VwSiteTableActionMenu
    },
    mixins: [
        MapContainerComponentStoreMx
    ],
    methods: {
        zoomToLayer() {
            this.mapContainerCallMethod('zoomToLayer', CID_MAP_LAYER_VECTOR_WFS_VW_SITES);
        }
    }
};
</script>

<style scoped>

</style>
