<template>
    <v-fragment>
        <map-footer-current-layer />
        <map-footer-pointer-coords />    </v-fragment>
</template>

<script>
import {Fragment as VFragment} from 'vue-fragment';
import MapFooterPointerCoords from './MapFooterPointerCoords';
import MapFooterCurrentLayer from './MapFooterCurrentLayer';

export default {
    name: 'MapFooterData',
    components: {
        VFragment,
        MapFooterCurrentLayer,
        MapFooterPointerCoords
    }
};
</script>

<style scoped>

</style>
