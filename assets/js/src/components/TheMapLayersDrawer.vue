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
                </map-legend-list-group>
                <map-legend-list-group
                    icon="border_all"
                    title="Survey basemaps"
                >
                    <map-legend-layer-list-tile
                        title="Akkad survey"
                        :layer-cid="WMTS_TYPENAME_SURVEY_TOPO_01_AKKAD"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_SURVEY_TOPO_01_AKKAD)"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_SURVEY_TOPO_01_AKKAD)"
                            :hide-details="true"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Land Beyond Baghdad survey"
                        :layer-cid="WMTS_TYPENAME_SURVEY_TOPO_02_LBB"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_SURVEY_TOPO_02_LBB)"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_SURVEY_TOPO_02_LBB)"
                            :hide-details="true"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Heartland of Cities"
                        :layer-cid="WMTS_TYPENAME_SURVEY_TOPO_03_HOC"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_SURVEY_TOPO_03_HOC)"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_SURVEY_TOPO_03_HOC)"
                            :hide-details="true"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Ur survey"
                        :layer-cid="WMTS_TYPENAME_SURVEY_TOPO_07_UR"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_SURVEY_TOPO_07_UR)"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_SURVEY_TOPO_07_UR)"
                            :hide-details="true"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Hammar lake survey"
                        :layer-cid="WMTS_TYPENAME_SURVEY_TOPO_10_HAMMAR"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_SURVEY_TOPO_10_HAMMAR)"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_SURVEY_TOPO_10_HAMMAR)"
                            :hide-details="true"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Mandali survey"
                        :layer-cid="WMTS_TYPENAME_SURVEY_TOPO_11_MANDALI"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_SURVEY_TOPO_11_MANDALI)"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_SURVEY_TOPO_11_MANDALI)"
                            :hide-details="true"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Myinab plain survey"
                        :layer-cid="WMTS_TYPENAME_SURVEY_TOPO_12_MYINAB"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_SURVEY_TOPO_12_MYINAB)"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_SURVEY_TOPO_12_MYINAB)"
                            :hide-details="true"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="South West Iran survey"
                        :layer-cid="WMTS_TYPENAME_SURVEY_TOPO_13_SWIRAN"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_SURVEY_TOPO_13_SWIRAN)"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_SURVEY_TOPO_13_SWIRAN)"
                            :hide-details="true"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Ras Hormuz survey"
                        :layer-cid="WMTS_TYPENAME_SURVEY_TOPO_14_HORMUZ"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_SURVEY_TOPO_14_HORMUZ)"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_SURVEY_TOPO_14_HORMUZ)"
                            :hide-details="true"
                        />
                    </map-legend-layer-list-tile>
                </map-legend-list-group>
                <map-legend-list-group
                    icon="border_all"
                    title="Topographic and satellite basemaps"
                >
                    <map-legend-layer-list-tile
                        title="US Army map (1942) 1"
                        :layer-cid="WMTS_TYPENAME_US_ARMY_TOPO_1"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_US_ARMY_TOPO_1)"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_US_ARMY_TOPO_1)"
                            :hide-details="true"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="US Army map (1942) 2"
                        :layer-cid="WMTS_TYPENAME_US_ARMY_TOPO_2"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_US_ARMY_TOPO_2)"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_US_ARMY_TOPO_2)"
                            disabled
                            :hide-details="true"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Corona FORE set"
                        :layer-cid="WMTS_TYPENAME_CORONA_FORE"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_CORONA_FORE)"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_CORONA_FORE)"
                            :hide-details="true"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Corona AFT set"
                        :layer-cid="WMTS_TYPENAME_CORONA_AFT"
                    >
                        <v-checkbox
                            slot="visibility"
                            :value="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_CORONA_AFT)"
                            @change="mapContainerWmtsMapToggleVisible(WMTS_TYPENAME_CORONA_AFT)"
                            :hide-details="true"
                        />
                    </map-legend-layer-list-tile>
                </map-legend-list-group>
                <map-legend-list-group
                    icon="map"
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
    CID_THE_MAP_LAYERS_DRAWER as CID,
    WFS_TYPENAME_VW_SITES_RS,
    WFS_TYPENAME_VW_SITES_SURVEY,
    WMTS_TYPENAME_CORONA_AFT,
    WMTS_TYPENAME_CORONA_FORE,
    WMTS_TYPENAME_SURVEY_TOPO_01_AKKAD,
    WMTS_TYPENAME_SURVEY_TOPO_02_LBB,
    WMTS_TYPENAME_SURVEY_TOPO_03_HOC,
    WMTS_TYPENAME_SURVEY_TOPO_07_UR,
    WMTS_TYPENAME_SURVEY_TOPO_10_HAMMAR,
    WMTS_TYPENAME_SURVEY_TOPO_11_MANDALI,
    WMTS_TYPENAME_SURVEY_TOPO_12_MYINAB,
    WMTS_TYPENAME_SURVEY_TOPO_13_SWIRAN,
    WMTS_TYPENAME_SURVEY_TOPO_14_HORMUZ,
    WMTS_TYPENAME_US_ARMY_TOPO_1,
    WMTS_TYPENAME_US_ARMY_TOPO_2

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
        WFS_TYPENAME_VW_SITES_RS: () => WFS_TYPENAME_VW_SITES_RS,
        WFS_TYPENAME_VW_SITES_SURVEY: () => WFS_TYPENAME_VW_SITES_SURVEY,
        WMTS_TYPENAME_CORONA_AFT: () => WMTS_TYPENAME_CORONA_AFT,
        WMTS_TYPENAME_CORONA_FORE: () => WMTS_TYPENAME_CORONA_FORE,
        WMTS_TYPENAME_SURVEY_TOPO_01_AKKAD: () => WMTS_TYPENAME_SURVEY_TOPO_01_AKKAD,
        WMTS_TYPENAME_SURVEY_TOPO_02_LBB: () => WMTS_TYPENAME_SURVEY_TOPO_02_LBB,
        WMTS_TYPENAME_SURVEY_TOPO_03_HOC: () => WMTS_TYPENAME_SURVEY_TOPO_03_HOC,
        WMTS_TYPENAME_SURVEY_TOPO_07_UR: () => WMTS_TYPENAME_SURVEY_TOPO_07_UR,
        WMTS_TYPENAME_SURVEY_TOPO_10_HAMMAR: () => WMTS_TYPENAME_SURVEY_TOPO_10_HAMMAR,
        WMTS_TYPENAME_SURVEY_TOPO_11_MANDALI: () => WMTS_TYPENAME_SURVEY_TOPO_11_MANDALI,
        WMTS_TYPENAME_SURVEY_TOPO_12_MYINAB: () => WMTS_TYPENAME_SURVEY_TOPO_12_MYINAB,
        WMTS_TYPENAME_SURVEY_TOPO_13_SWIRAN: () => WMTS_TYPENAME_SURVEY_TOPO_13_SWIRAN,
        WMTS_TYPENAME_SURVEY_TOPO_14_HORMUZ: () => WMTS_TYPENAME_SURVEY_TOPO_14_HORMUZ,
        WMTS_TYPENAME_US_ARMY_TOPO_1: () => WMTS_TYPENAME_US_ARMY_TOPO_1,
        WMTS_TYPENAME_US_ARMY_TOPO_2: () => WMTS_TYPENAME_US_ARMY_TOPO_2,
    }
};
</script>
