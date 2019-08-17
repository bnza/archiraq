<template>
    <v-fragment>
        <vw-site-form-action-menu />

        <v-toolbar-title>{{ title }}</v-toolbar-title>
    </v-fragment>
</template>

<script>
import {Fragment as VFragment} from 'vue-fragment';
import VwSiteFormActionMenu from './ListRowMenu/VwSiteFormActionMenu';
import VwSiteActionDataCardToolbarMx from '@/mixins/DataCard/VwSiteActionDataCardToolbarMx';
import MapContainerComponentStoreMx from '@/mixins/MapContainerComponentStoreMx';

export default {
    name: 'VwSiteDataCardToolbar',
    components: {
        VFragment,
        VwSiteFormActionMenu
    },
    mixins: [
        VwSiteActionDataCardToolbarMx,
        MapContainerComponentStoreMx
    ],
};
</script>

<style scoped>

</style>
