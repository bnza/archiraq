<template>
    <v-list-tile
        @click="toggleMapLayersDrawerVisibilityAndHideMainDrawer"
    >
        <v-list-tile-action>
            <v-btn
                icon
            >
                <v-icon>{{ icon }}</v-icon>
            </v-btn>
        </v-list-tile-action>
        <v-list-tile-content>
            <v-list-tile-title>{{ tooltipText }}</v-list-tile-title>
        </v-list-tile-content>
    </v-list-tile>
</template>

<script>
import MapDrawerMx from '../mixins/Controller/MapDrawerMx';
import {CID_THE_MAIN_NAVIGATION_DRAWER} from '../utils/cids';

export default {
    name: 'MapToolbarFullscreenButton',
    mixins: [
        MapDrawerMx
    ],
    methods: {
        toggleMapLayersDrawerVisibilityAndHideMainDrawer() {
            this.toggleMapLayersDrawerVisibility();
            this.componentsSetComponentProp({cid: CID_THE_MAIN_NAVIGATION_DRAWER, prop: 'visible', value: false});
        }
    }
};
</script>

<style scoped>

</style>
