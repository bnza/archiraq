<template>
    <v-card
        flat
    >
        <v-navigation-drawer
            data-test="the-map-layers-drawer--aside"
            right
            floating
            absolute
            :value="visible"
            width="400"
            :style="'z-index: 1; min-height: '+mapContainerHeight"
            flat
            @input="syncVisible"
        >
            <v-list dense>
                <map-legend-list-group
                    icon="place"
                    title="Sites"
                >
                    <map-legend-layer-list-tile
                        title="Survey"
                        :layer-cid="WFS_TYPENAME_VW_SITES_SURVEY"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerVwSitesSurveyVisible"
                            :hide-details="true"
                            data-test="the-map-layers-drawer--checkbox-vw-sites"
                        />
                        <wv-site-layer-action-menu
                            slot="action"
                            :typename="WFS_TYPENAME_VW_SITES_SURVEY"
                            @zoomToLayer="zoomToLayerExtent('vw_site_survey')"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Remote Sensing"
                        :layer-cid="WFS_TYPENAME_VW_SITES_RS"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerVwSitesRemoteSensingVisible"
                            :hide-details="true"
                            data-test="the-map-layers-drawer--checkbox-vw-sites"
                        />
                        <wv-site-layer-action-menu
                            slot="action"
                            :typename="WFS_TYPENAME_VW_SITES_RS"
                            @zoomToLayer="zoomToLayerExtent('vw_site_rs')"
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
                            :hide-details="true"
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
                            :hide-details="true"
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
                            :hide-details="true"
                            data-test="the-map-layers-drawer--checkbox-admin-bounds-2-visibility"
                            :value="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Sub-Districts"
                        :layer-cid="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_3"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerAdminBounds"
                            :hide-details="true"
                            data-test="the-map-layers-drawer--checkbox-admin-bounds-3-visibility"
                            :value="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_3"
                        />
                    </map-legend-layer-list-tile>
                </map-legend-list-group>
                <map-legend-list-group
                    icon="map"
                    title="Survey areas"
                >
                    <map-legend-layer-list-tile
                        v-for="layer in WFS_TYPENAME_SURVEY_AREAS"
                        :key="layer.typename"
                        :title="layer.title"
                        :layer-cid="layer.typename"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(layer.typename)"
                            :hide-details="true"
                            @change="mapContainerWmtsMapToggleVisible(layer.typename)"
                        />
                    </map-legend-layer-list-tile>
                </map-legend-list-group>
                <map-legend-list-group
                    icon="map"
                    title="Survey basemaps"
                >
                    <map-legend-layer-list-tile
                        v-for="layer in WMTS_TYPENAME_SURVEY_TOPOS"
                        :key="layer.typename"
                        :title="layer.title"
                        :layer-cid="layer.typename"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(layer.typename)"
                            :hide-details="true"
                            @change="mapContainerWmtsMapToggleVisible(layer.typename)"
                        />
                    </map-legend-layer-list-tile>
                </map-legend-list-group>
                <map-legend-list-group
                    icon="border_all"
                    title="Topographic and satellite basemaps"
                >
                    <map-legend-layer-list-tile
                        title="Geomorphological (boundaries)"
                        :layer-cid="WMTS_TYPENAME_GEOMORPHOLOGICAL_BOUNDARIES"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_GEOMORPHOLOGICAL_BOUNDARIES)"
                            :hide-details="true"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_GEOMORPHOLOGICAL_BOUNDARIES)"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Geomorphological"
                        :layer-cid="WMTS_TYPENAME_GEOMORPHOLOGICAL"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_GEOMORPHOLOGICAL)"
                            :hide-details="true"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_GEOMORPHOLOGICAL)"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="US Army map (1942) 1"
                        :layer-cid="WMTS_TYPENAME_US_ARMY_TOPO_1"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_US_ARMY_TOPO_1)"
                            :hide-details="true"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_US_ARMY_TOPO_1)"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="US Army map (1942) 2"
                        :layer-cid="WMTS_TYPENAME_US_ARMY_TOPO_2"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_US_ARMY_TOPO_2)"
                            :hide-details="true"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_US_ARMY_TOPO_2)"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        v-for="layer in WMTS_TYPENAME_CORONA"
                        :key="layer.typename"
                        :title="layer.title"
                        :layer-cid="layer.typename"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(layer.typename)"
                            :hide-details="true"
                            @change="mapContainerWmtsMapToggleVisible(layer.typename)"
                        />
                    </map-legend-layer-list-tile>
                </map-legend-list-group>
                <map-legend-list-group
                    icon="grid_on"
                    title="Online basemaps"
                >
                    <map-legend-layer-list-tile
                        title="Esri Basemap"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerBaseMap"
                            :hide-details="true"
                            data-test="the-map-layers-drawer--checkbox-base-map-esri-visibility"
                            value="esri"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Bing Maps"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerBaseMap"
                            :hide-details="true"
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
                            :hide-details="true"
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
import BingBaseMapSettingsDialogLayout from './BingBaseMapSettingsDialogLayout';
import WvSiteLayerActionMenu from '@/components/DataCard/ListRowMenu/WvSiteLayerActionMenu';
import ComponentStoreVisibleMx from '@/mixins/ComponentStoreVisibleMx';
import MapContainerComponentStoreMx from '@/mixins/MapContainerComponentStoreMx';
import {
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_3,
    CID_THE_MAP_LAYERS_DRAWER as CID,
    WFS_TYPENAME_VW_SITES_RS,
    WFS_TYPENAME_VW_SITES_SURVEY,
    WMTS_TYPENAME_CORONA_AFT,
    WMTS_TYPENAME_CORONA_FORE,
    WMTS_TYPENAME_US_ARMY_TOPO_1,
    WMTS_TYPENAME_US_ARMY_TOPO_2,
    WMTS_TYPENAME_GEOMORPHOLOGICAL,
    WMTS_TYPENAME_GEOMORPHOLOGICAL_BOUNDARIES,
    WMTS_TYPENAME_SURVEY_TOPOS,
    WFS_TYPENAME_SURVEY_AREAS,
    WMTS_TYPENAME_CORONA

} from '../utils/cids';

export default {
    name: CID,
    components: {
        MapLegendLayerListTile,
        MapLegendListGroup,
        MapLayerSettingsDialog,
        WvSiteLayerActionMenu,
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
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0,
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1,
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2,
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_3: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_3,
        WFS_TYPENAME_VW_SITES_RS: () => WFS_TYPENAME_VW_SITES_RS,
        WFS_TYPENAME_VW_SITES_SURVEY: () => WFS_TYPENAME_VW_SITES_SURVEY,
        WMTS_TYPENAME_CORONA: () => WMTS_TYPENAME_CORONA,
        WMTS_TYPENAME_CORONA_AFT: () => WMTS_TYPENAME_CORONA_AFT,
        WMTS_TYPENAME_CORONA_FORE: () => WMTS_TYPENAME_CORONA_FORE,
        WMTS_TYPENAME_US_ARMY_TOPO_1: () => WMTS_TYPENAME_US_ARMY_TOPO_1,
        WMTS_TYPENAME_US_ARMY_TOPO_2: () => WMTS_TYPENAME_US_ARMY_TOPO_2,
        WMTS_TYPENAME_GEOMORPHOLOGICAL: () => WMTS_TYPENAME_GEOMORPHOLOGICAL,
        WMTS_TYPENAME_GEOMORPHOLOGICAL_BOUNDARIES: () => WMTS_TYPENAME_GEOMORPHOLOGICAL_BOUNDARIES,
        WFS_TYPENAME_SURVEY_AREAS: () => WFS_TYPENAME_SURVEY_AREAS,
        WMTS_TYPENAME_SURVEY_TOPOS: () => WMTS_TYPENAME_SURVEY_TOPOS

    }
};
</script>
