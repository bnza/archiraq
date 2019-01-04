<template>
    <v-card
        data-cy="the-map-layers-drawer"
        flat
    >
        <v-navigation-drawer
            floating
            absolute
            :value="visible"
            width="400"
            style="min-height: 400px; z-index: 1;"
        >
            <v-list dense>
                <v-list-group
                    prepend-icon="layers"
                    no-action
                >
                    <v-list-tile slot="activator">
                        <v-list-tile-content>
                            <v-list-tile-title>Administrative boundaries</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>

                    <map-legend-layer-list-tile
                        :layer-cid="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0"
                        title="Nations"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerComponentStoreMx_currentAdminBoundsLayer"
                            :value="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0"
                        />
                    </map-legend-layer-list-tile>

                    <map-legend-layer-list-tile
                        :layer-cid="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1"
                        title="Governorates"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerComponentStoreMx_currentAdminBoundsLayer"
                            :value="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        :layer-cid="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2"
                        title="Districts"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerComponentStoreMx_currentAdminBoundsLayer"
                            :value="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2"
                        />
                    </map-legend-layer-list-tile>
                </v-list-group>
                <v-list-group
                    prepend-icon="map"
                    no-action
                >
                    <v-list-tile slot="activator">
                        <v-list-tile-content>
                            <v-list-tile-title>Base maps</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <map-legend-layer-list-tile
                        title="Bing Maps"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerComponentStoreMx_currentBaseMap"
                            value="bing"
                        />
                        <v-list slot="action">
                            <v-list-tile>
                                <v-list-tile-title>Choose imagery set</v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile @click="mapContainerComponentStoreMx_currentBingImagerySet='Aerial'">
                                <v-list-tile-title>Aerial</v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile @click="mapContainerComponentStoreMx_currentBingImagerySet='AerialWithLabels'">
                                <v-list-tile-title>Aerial with labels</v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile @click="mapContainerComponentStoreMx_currentBingImagerySet='RoadOnDemand'">
                                <v-list-tile-title>Road (dynamic)</v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile @click="mapContainerComponentStoreMx_currentBingImagerySet='Road'">
                                <v-list-tile-title>Road (static)</v-list-tile-title>
                            </v-list-tile>
                        </v-list>
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Open Street Map"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerComponentStoreMx_currentBaseMap"
                            value="osm"
                        />
                    </map-legend-layer-list-tile>
                </v-list-group>
            </v-list>
        </v-navigation-drawer>
    </v-card>
</template>

<script>
import {
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2,
    CID_THE_MAP_LAYERS_DRAWER
} from '../utils/constants';
import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';
import MapLegendLayerListTile from './MapLegendLayerListTile';

export default {
    name: 'TheMapLayersDrawer',
    components: {
        MapLegendLayerListTile
    },
    mixins: [
        MapContainerComponentStoreMx
    ],
    data() {
        return {
            componentStoreMx_cid: CID_THE_MAP_LAYERS_DRAWER
        };
    },
    computed: {
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0,
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1,
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2,
        visible: {
            get() {
                return this.componentStoreMx_getStoreProp('visible');
            },
            set(value) {
                this.componentStoreMx_setStoreProp('visible', value);
            }
        }
    },
    created() {
        this.visible = false;
    },
};
</script>

<style scoped>

</style>
