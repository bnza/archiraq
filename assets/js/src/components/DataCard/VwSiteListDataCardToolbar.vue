<template>
    <v-fragment>
        <vw-site-table-action-menu
            @openModal="$emit('openModal', $event)"
        />

        <v-toolbar-title>Site</v-toolbar-title>
    </v-fragment>
</template>

<script>
import {Fragment as VFragment} from 'vue-fragment';
import VwSiteTableActionMenu from './ListRowMenu/VwSiteTableActionMenu';
export default {
    name: 'VwSiteDataCardToolbar',
    components: {
        VFragment,
        VwSiteTableActionMenu
    }
};
</script>

<style scoped>

</style>
