<template>
    <v-card
        flat
    >
        <v-navigation-drawer
            data-test="the-map-layers-drawer--aside"
            floating
            absolute
            :value="visible"
            width="400"
            :style="'z-index: 1; min-height: '+mapContainerHeight"
            flat
        >
            <v-list dense>
                <map-legend-list-group
                    icon="place"
                    title="Sites"
                >
                    <map-legend-layer-list-tile
                        title="Sites"
                        :layer-cid="CID_MAP_LAYER_VECTOR_WFS_VW_SITES"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerVwSitesVisible"
                            data-test="the-map-layers-drawer--checkbox-vw-sites"
                        />
                        <open-attribute-table-button
                            slot="action"
                            table="vw-site"
                        />
                    </map-legend-layer-list-tile>
                </map-legend-list-group>
                <map-legend-list-group
                    icon="layers"
                    title="Administrative boundaries"
                >
                    <map-legend-layer-list-tile
                        title="Nations"
                        :layer-cid="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerAdminBounds"
                            data-test="the-map-layers-drawer--checkbox-admin-bounds-0-visibility"
                            :value="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Governorates"
                        :layer-cid="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerAdminBounds"
                            data-test="the-map-layers-drawer--checkbox-admin-bounds-1-visibility"
                            :value="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Districts"
                        :layer-cid="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerAdminBounds"
                            data-test="the-map-layers-drawer--checkbox-admin-bounds-2-visibility"
                            :value="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2"
                        />
                    </map-legend-layer-list-tile>
                </map-legend-list-group>
                <map-legend-list-group
                    icon="map"
                    title="Base Maps"
                >
                    <map-legend-layer-list-tile
                        title="Bing Maps"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerBaseMap"
                            data-test="the-map-layers-drawer--checkbox-base-map-bing-visibility"
                            value="bing"
                        />
                        <map-layer-settings-dialog
                            slot="action"
                            title="Bing Maps"
                        >
                            <bing-base-map-settings-dialog-layout />
                        </map-layer-settings-dialog>
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Open Street Map"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerBaseMap"
                            data-test="the-map-layers-drawer--checkbox-base-map-osm-visibility"
                            value="osm"
                        />
                    </map-legend-layer-list-tile>
                </map-legend-list-group>
            </v-list>
        </v-navigation-drawer>
    </v-card>
</template>

<script>
import MapLegendLayerListTile from './MapLegendLayerListTile';
import MapLegendListGroup from './MapLegendListGroup';
import MapLayerSettingsDialog from './MapLayerSettingsDialog';
import OpenAttributeTableButton from './OpenAttributeTableButton';
import BingBaseMapSettingsDialogLayout from './BingBaseMapSettingsDialogLayout';
import ComponentStoreVisibleMx from '../mixins/ComponentStoreVisibleMx';
import MapContainerComponentStoreMx from '../mixins/MapContainerComponentStoreMx';
import {
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2,
    CID_MAP_LAYER_VECTOR_WFS_VW_SITES,
    CID_THE_MAP_LAYERS_DRAWER as CID
} from '../utils/cids';

export default {
    name: CID,
    components: {
        MapLegendLayerListTile,
        MapLegendListGroup,
        MapLayerSettingsDialog,
        OpenAttributeTableButton,
        BingBaseMapSettingsDialogLayout
    },
    mixins: [
        ComponentStoreVisibleMx,
        MapContainerComponentStoreMx
    ],
    data() {
        return {
            cid: CID
        };
    },
    computed: {
        CID_MAP_LAYER_VECTOR_WFS_VW_SITES: () => CID_MAP_LAYER_VECTOR_WFS_VW_SITES,
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0,
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1,
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2
    }
};
</script>

