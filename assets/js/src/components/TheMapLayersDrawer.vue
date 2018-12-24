<template>
    <v-card
            flat
    >
        <v-navigation-drawer
                floating
                absolute
                :value=visible
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
                                <v-checkbox v-model="$_MapContainerComponentStoreMx_currentBaseMap" value="bing"></v-checkbox>
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
                                    <v-list-tile @click="$_MapContainerComponentStoreMx_currentBingImagerySet='Aerial'">
                                        <v-list-tile-title>Aerial</v-list-tile-title>
                                    </v-list-tile>
                                    <v-list-tile @click="$_MapContainerComponentStoreMx_currentBingImagerySet='AerialWithLabels'">
                                        <v-list-tile-title>Aerial with labels</v-list-tile-title>
                                    </v-list-tile>
                                    <v-list-tile @click="$_MapContainerComponentStoreMx_currentBingImagerySet='RoadOnDemand'">
                                        <v-list-tile-title>Road (dynamic)</v-list-tile-title>
                                    </v-list-tile>
                                    <v-list-tile @click="$_MapContainerComponentStoreMx_currentBingImagerySet='Road'">
                                        <v-list-tile-title>Road (static)</v-list-tile-title>
                                    </v-list-tile>
                                </v-list>
                            </v-menu>

                        </v-list-tile-action>
                    </v-list-tile>
                    <v-list-tile>
                        <v-list-tile-action>
                            <v-list-tile-action>
                                <v-checkbox v-model="$_MapContainerComponentStoreMx_currentBaseMap" value="osm"></v-checkbox>
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
    import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx'

    export default {
        name: "TheMapLayersDrawer",
        data() {
            return {
                items: [
                    {title: 'Home', icon: 'dashboard'},
                    {title: 'About', icon: 'question_answer'}
                ],
                right: null
            }
        },
        mixins: [
            MapContainerComponentStoreMx
        ],
        computed: {
            visible: {
                get() {
                    return this.$_ComponentStoreMx_getStoreProp('visible')
                },
                set(value) {
                    this.$_ComponentStoreMx_setStoreProp('visible', value)
                }
            }
        },
        created() {
            this.visible = false
        },
    }
</script>

<style scoped>

</style>