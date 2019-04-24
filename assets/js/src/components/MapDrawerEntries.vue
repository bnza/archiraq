<template>
    <v-list-group
        prepend-icon="map"
        no-action
    >
        <v-list-tile
            slot="activator"
        >
            <v-list-tile-content>
                <v-list-tile-title>Map</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <map-drawer-fullscreen-tile />
        <map-drawer-toggle-drawer-tile />
    </v-list-group>
</template>

<script>
import MapDrawerFullscreenTile from './MapDrawerFullscreenTile';
import MapDrawerToggleDrawerTile from './MapDrawerToggleDrawerTile';

export default {
    name: 'MapDrawerEntries',
    components: {
        MapDrawerFullscreenTile,
        MapDrawerToggleDrawerTile
    }
};
</script>

<style scoped>

</style>
