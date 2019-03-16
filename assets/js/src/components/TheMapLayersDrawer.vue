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
                        :layer-cid="CID_VW_SITES"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerVwSitesVisible"
                            data-test="the-map-layers-drawer--checkbox-vw-sites"
                        />
                    </map-legend-layer-list-tile>
                </map-legend-list-group>
                <map-legend-list-group
                    icon="layers"
                    title="Administrative boundaries"
                >
                    <map-legend-layer-list-tile
                        title="Nations"
                        :layer-cid="CID_ADMIN_BOUNDS_NATIONS"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerAdminBounds"
                            data-test="the-map-layers-drawer--checkbox-admin-bounds-0-visibility"
                            :value="CID_ADMIN_BOUNDS_NATIONS"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Governorates"
                        :layer-cid="CID_ADMIN_BOUNDS_GOVERNORATES"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerAdminBounds"
                            data-test="the-map-layers-drawer--checkbox-admin-bounds-1-visibility"
                            :value="CID_ADMIN_BOUNDS_GOVERNORATES"
                        />
                    </map-legend-layer-list-tile>
                    <map-legend-layer-list-tile
                        title="Districts"
                        :layer-cid="CID_ADMIN_BOUNDS_DISTRICTS"
                    >
                        <v-checkbox
                            slot="visibility"
                            v-model="mapContainerAdminBounds"
                            data-test="the-map-layers-drawer--checkbox-admin-bounds-2-visibility"
                            :value="CID_ADMIN_BOUNDS_DISTRICTS"
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
                        <map-layer-setting-dialog
                            slot="action"
                            title="Bing Maps"
                        >
                            <bing-base-map-settings-dialog-layout />
                        </map-layer-setting-dialog>
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
import MapLayerSettingDialog from './MapLayerSettingDialog';
import BingBaseMapSettingsDialogLayout from './BingBaseMapSettingsDialogLayout';
import ComponentStoreVisibleMx from '../mixins/ComponentStoreVisibleMx';
import MapContainerComponentStoreMx from '../mixins/MapContainerComponentStoreMx';
import {CID_ADMIN_BOUNDS_DISTRICTS, CID_ADMIN_BOUNDS_GOVERNORATES, CID_ADMIN_BOUNDS_NATIONS} from './MapLayerGroupAdminBounds';
import {CID as CID_VW_SITES} from './MapLayerVectorWfsVwSites';

export const CID = 'TheMapLayersDrawer';

export default {
    name: CID,
    components: {
        MapLegendLayerListTile,
        MapLegendListGroup,
        MapLayerSettingDialog,
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
        CID_VW_SITES: () => CID_VW_SITES,
        CID_ADMIN_BOUNDS_NATIONS: () => CID_ADMIN_BOUNDS_NATIONS,
        CID_ADMIN_BOUNDS_GOVERNORATES: () => CID_ADMIN_BOUNDS_GOVERNORATES,
        CID_ADMIN_BOUNDS_DISTRICTS: () => CID_ADMIN_BOUNDS_DISTRICTS
    }
};
</script>

