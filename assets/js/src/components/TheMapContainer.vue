<template>
    <v-card flat>
        <the-map-toolbar />
        <vl-map
            ref="map"
            data-test="the-map-container"
            :load-tiles-while-animating="true"
            :load-tiles-while-interacting="true"
            data-projection="EPSG:4326"
            :style="'height: '+mapContainerHeight"
        >
            <vl-view
                :zoom.sync="zoom"
                :center.sync="center"
                :rotation.sync="rotation"
                projection="EPSG:4326"
            />
            <vl-layer-tile
                id="bingmaps"
                data-test="base-map-tile-bingmaps"
                :visible="'bing'===mapContainerBaseMap"
            >
                <vl-source-bingmaps
                    :api-key="bingApiKey"
                    :imagery-set="mapContainerBingImagerySet"
                />
            </vl-layer-tile>
            <vl-layer-tile
                id="osm"
                data-test="base-map-tile-osm"
                :visible="'osm'===mapContainerBaseMap"
            >
                <vl-source-osm />
            </vl-layer-tile>
            <map-layer-group-admin-bounds />
            <map-layer-vector-wfs-vw-sites />
            <the-map-layers-drawer />
        </vl-map>
    </v-card>
</template>

<script>
import ComponentStoreVisibleMx from '../mixins/ComponentStoreVisibleMx';
import MapContainerComponentStoreMx from '../mixins/MapContainerComponentStoreMx';
import TheMapToolbar from './TheMapToolbar';
import TheMapLayersDrawer from './TheMapLayersDrawer';
import MapLayerGroupAdminBounds from './MapLayerGroupAdminBounds';
import MapLayerVectorWfsVwSites from './MapLayerVectorWfsVwSites';
import {
    CID_THE_MAP_CONTAINER as CID,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2,
    CID_MAP_LAYER_VECTOR_WFS_VW_SITES
} from '../utils/cids';

export const HEIGHT = '500px';

export default {
    name: CID,
    components: {
        TheMapToolbar,
        TheMapLayersDrawer,
        MapLayerVectorWfsVwSites,
        MapLayerGroupAdminBounds,
    },
    mixins: [
        ComponentStoreVisibleMx,
        MapContainerComponentStoreMx
    ],
    data() {
        return {
            cid: CID,
            zoom: 6,
            center: [0, 0],
            rotation: 0,
        };
    },
    computed: {
        bingApiKey() {
            return this.$store.state.bingApiKey;
        }
    },
    created() {
        this.mapContainerHeight = HEIGHT;
        this.mapContainerAdminBounds = CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2;
        this.mapContainerCurrentLayer = CID_MAP_LAYER_VECTOR_WFS_VW_SITES;
        this.mapContainerBaseMap = 'bing';
        this.mapContainerBingImagerySet = 'AerialWithLabels';
    },
    mounted() {
        // get vl-map by ref="map" and await ol.Map creation
        this.$refs.map.$createPromise.then(() => {
            this.center = [47.44, 33.37];
            if (process.env.NODE_ENV !== 'production') {
                window.map = this.$refs.map.$map;
            }
        });
    },
};
</script>

<style scoped>

</style>
