<template>
    <v-fragment>
        <vw-site-table-action-menu
            @openModal="$emit('openModal', $event)"
            @zoomToLayer="zoomToLayer"
        />

        <v-toolbar-title>{{title}}</v-toolbar-title>
    </v-fragment>
</template>

<script>
import {Fragment as VFragment} from 'vue-fragment';
import VwSiteTableActionMenu from './ListRowMenu/VwSiteTableActionMenu';
import MapContainerComponentStoreMx from '@/mixins/MapContainerComponentStoreMx';
import {WFS_TYPENAME_VW_SITES_SURVEY, WFS_TYPENAME_VW_SITES_RS} from '@/utils/cids';

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
    computed: {
        title() {
            const titles = {
                [WFS_TYPENAME_VW_SITES_SURVEY]: 'Sites (survey)',
                [WFS_TYPENAME_VW_SITES_RS]: 'Sites (remote sensing)',
            };
            return titles[this.layerId] || 'Sites';
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
