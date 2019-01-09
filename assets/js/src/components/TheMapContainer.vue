<template>
    <v-card flat>
        <the-map-toolbar />
        <vl-map
            ref="map"
            :data-test="DT_THE_MAP_CONTAINER"
            :load-tiles-while-animating="true"
            :load-tiles-while-interacting="true"
            data-projection="EPSG:4326"
            style="height: 400px"
        >
            <vl-view
                :zoom.sync="zoom"
                :center.sync="center"
                :rotation.sync="rotation"
                projection="EPSG:4326"
            />
            <!-- Base Maps -->
            <vl-layer-tile
                id="bingmaps"
                :visible="'bing'===mapContainerComponentStoreMx_currentBaseMap"
            >
                <vl-source-bingmaps
                    :api-key="apiKey"
                    :imagery-set="mapContainerComponentStoreMx_currentBingImagerySet"
                />
            </vl-layer-tile>
            <vl-layer-tile
                id="osm"
                :visible="'osm'===mapContainerComponentStoreMx_currentBaseMap"
            >
                <vl-source-osm />
            </vl-layer-tile>
            <!--// Base Maps -->
            <map-admin-bounds-layer-group />
            <the-map-layers-drawer />
            <the-map-properties-drawer />
        </vl-map>
    </v-card>
</template>

<script>
//import ol from 'ol';
import {
    CID_THE_MAP_CONTAINER,
    DT_THE_MAP_CONTAINER,
} from '../utils/constants';
import TheMapLayersDrawer from './TheMapLayersDrawer';
import TheMapToolbar from './TheMapToolbar';
import TheMapPropertiesDrawer from './TheMapPropertiesDrawer';
import MapAdminBoundsLayerGroup from './MapAdminBoundsLayerGroup';
import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';

export default {
    name: 'TheMapContainer',
    components: {
        MapAdminBoundsLayerGroup,
        TheMapLayersDrawer,
        TheMapToolbar,
        TheMapPropertiesDrawer
    },
    mixins: [
        MapContainerComponentStoreMx
    ],
    data() {
        return {
            zoom: 6,
            center: [0, 0],
            rotation: 0,
            apiKey: this.$store.state.bingApiKey,
            componentStoreMx_cid: CID_THE_MAP_CONTAINER
        };
    },
    computed: {
        DT_THE_MAP_CONTAINER: () => DT_THE_MAP_CONTAINER
    },
    created() {
        this.mapContainerComponentStoreMx_currentBaseMap = this.$store.state.default.baseMap;
        this.mapContainerComponentStoreMx_currentBingImagerySet =  this.$store.state.default.bingImagerySet;
        this.mapContainerComponentStoreMx_currentLayer =  this.$store.state.default.currentLayer;
        this.mapContainerComponentStoreMx_selectedFeatures =  [];
    },
    mounted () {
        // get vl-map by ref="map" and await ol.Map creation
        this.$refs.map.$createPromise.then(() => {
            this.center = [ 47.44, 33.37];
            if (process.env.NODE_ENV !== 'production') {
                window.map = this.$refs.map.$map;
                //window.ol = ol;
            }
        });
    },
    methods: {

    },
};
</script>

<style scoped>

</style>
