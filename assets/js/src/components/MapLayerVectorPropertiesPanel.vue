<template>
        <component :is="mapLayerVectorWfsFeaturePropertyCard">
            <v-toolbar
                    slot="toolbar"
                    color="white"
                    dense
                    flat
            >
                <v-toolbar-title
                    class="subheading"
                >
                    {{mapContainerComponentStoreMx_currentLayer}}
                </v-toolbar-title>
            </v-toolbar>
            <v-card
                flat
                slot="card"
            >
                <v-card-title>
                    <div>
                        Selected features:
                        <span
                            :data-test="DT_THE_MAP_PROPERTIES_DRAWER_SELECTED_FEATURES_NUM"
                    >{{mapContainerComponentStoreMx_selectedFeatures.length}}</span>
                    </div>
                </v-card-title>
            </v-card>
        </component>
</template>

<script>
    import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';
    import {DT_THE_MAP_PROPERTIES_DRAWER_SELECTED_FEATURES_NUM} from '../utils/constants';

    export default {
    name: 'MapLayerVectorPropertiesPanel',
    components: {
        MapLayerVectorWfsAdminBounds2FeaturePropertiesPanel: () => import(
            /* webpackChunkName: "MapLayerVectorWfsAdminBounds2FeaturePropertiesPanel" */
            './MapLayerVectorWfsAdminBounds2FeaturePropertiesPanel'
            ),
    },
    mixins: [
        MapContainerComponentStoreMx
    ],
    properties: {
        layer: {
            type: String
        }
    },
    computed: {
        DT_THE_MAP_PROPERTIES_DRAWER_SELECTED_FEATURES_NUM: () => DT_THE_MAP_PROPERTIES_DRAWER_SELECTED_FEATURES_NUM,
        mapLayerVectorWfsFeaturePropertyCard() {
            return `${this.mapContainerComponentStoreMx_currentLayer}FeaturePropertiesPanel`;
        },
    }
};
</script>

<style scoped>

</style>
