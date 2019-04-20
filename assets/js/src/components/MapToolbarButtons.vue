<template>
    <v-fragment>
        <map-toolbar-fullscreen-button />
        <map-toolbar-toggle-drawer-button />
    </v-fragment>
</template>

<script>
import {Fragment as VFragment} from 'vue-fragment';
import MapToolbarFullscreenButton from './MapToolbarFullscreenButton';
import MapToolbarToggleDrawerButton from './MapToolbarToggleDrawerButton';

export default {
    name: 'MapToolbarButtons',
    components: {
        VFragment,
        MapToolbarFullscreenButton,
        MapToolbarToggleDrawerButton
    }
};
</script>

<style scoped>

</style>
