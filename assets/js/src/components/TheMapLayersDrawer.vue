<template>
    <v-card
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
                    prepend-icon="map"
                    no-action
                >
                    <v-list-tile slot="activator">
                        <v-list-tile-content>
                            <v-list-tile-title>Base maps</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile>
                        <v-list-tile-action>
                            <v-list-tile-action>
                                <v-checkbox
                                    v-model="mapContainerComponentStoreMx_currentBaseMap"
                                    value="bing"
                                />
                            </v-list-tile-action>
                        </v-list-tile-action>

                        <v-list-tile-content>
                            <v-list-tile-title>Bing Maps</v-list-tile-title>
                        </v-list-tile-content>

                        <v-list-tile-action>
                            <v-menu offset-y>
                                <v-btn
                                    slot="activator"
                                    color="primary"
                                    icon
                                    flat
                                >
                                    <v-icon>more_vert</v-icon>
                                </v-btn>
                                <v-list>
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
                            </v-menu>
                        </v-list-tile-action>
                    </v-list-tile>
                    <v-list-tile>
                        <v-list-tile-action>
                            <v-list-tile-action>
                                <v-checkbox
                                    v-model="mapContainerComponentStoreMx_currentBaseMap"
                                    value="osm"
                                />
                            </v-list-tile-action>
                        </v-list-tile-action>

                        <v-list-tile-content>
                            <v-list-tile-title>Open Street Map</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list-group>
            </v-list>
        </v-navigation-drawer>
    </v-card>
</template>

<script>
import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';

export default {
    name: 'TheMapLayersDrawer',
    mixins: [
        MapContainerComponentStoreMx
    ],
    data() {
        return {
            componentStoreMx_cid: 'the-map-layers-drawer'
        };
    },
    computed: {
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