<template>
    <v-fragment>
        <v-toolbar-title>{{ title }} - Edit</v-toolbar-title>
    </v-fragment>
</template>

<script>
import {Fragment as VFragment} from 'vue-fragment';
import VwSiteActionDataCardToolbarMx from '@/mixins/DataCard/VwSiteActionDataCardToolbarMx';

export default {
    name: 'VwSiteEditDataCardToolbar',
    components: {
        VFragment,
    },
    mixins: [
        VwSiteActionDataCardToolbarMx,
    ],
};
</script>

<style scoped>

</style>
