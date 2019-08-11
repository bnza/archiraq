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

export default {
    name: 'VwSiteDataCardToolbar',
    components: {
        VFragment,
        VwSiteTableActionMenu
    },
    mixins: [
        MapContainerComponentStoreMx
    ],
    props: {
        layerId: {
            type: String,
            required: true
        }
    },
    methods: {
        zoomToLayer() {
            this.mapContainerCallMethod('zoomToLayer', this.layerId);
        }
    }
};
</script>

<style scoped>

</style>
