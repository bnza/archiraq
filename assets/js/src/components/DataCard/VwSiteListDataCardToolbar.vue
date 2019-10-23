<template>
    <v-fragment>
        <vw-site-table-action-menu
            @openModal="$emit('openModal', $event)"
            @zoomToLayer="zoomToLayerExtent(layerId)"
        />

        <v-toolbar-title>{{ title }}</v-toolbar-title>
    </v-fragment>
</template>

<script>
import {Fragment as VFragment} from 'vue-fragment';
import VwSiteTableActionMenu from './ListRowMenu/VwSiteTableActionMenu';
import VwSiteActionDataCardToolbarMx from '@/mixins/DataCard/VwSiteActionDataCardToolbarMx';
import MapContainerComponentStoreMx from '@/mixins/MapContainerComponentStoreMx';

export default {
    name: 'VwSiteDataCardToolbar',
    components: {
        VFragment,
        VwSiteTableActionMenu
    },
    mixins: [
        VwSiteActionDataCardToolbarMx,
        MapContainerComponentStoreMx
    ]
};
</script>

<style scoped>

</style>
