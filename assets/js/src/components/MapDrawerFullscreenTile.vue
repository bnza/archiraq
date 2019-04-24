<template>
    <v-list-tile
        @click="toggleFullScreen"
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
import MapFullScreenMx from '../mixins/Controller/MapFullScreenMx';

export default {
    name: 'MapToolbarFullscreenButton',
    mixins: [
        MapFullScreenMx
    ]
};
</script>

<style scoped>

</style>
