<template>
    <v-card flat>
        <the-map-toolbar />
        <vl-map
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
            <vl-layer-tile
                id="bingmaps"
                :visible="'bing'===$_MapContainerComponentStoreMx_currentBaseMap"
            >
                <vl-source-bingmaps
                    :api-key="apiKey"
                    :imagery-set="$_MapContainerComponentStoreMx_currentBingImagerySet"
                />
            </vl-layer-tile>
            <vl-layer-tile
                id="osm"
                :visible="'osm'===$_MapContainerComponentStoreMx_currentBaseMap"
            >
                <vl-source-osm />
            </vl-layer-tile>
            <the-map-layers-drawer />
        </vl-map>
    </v-card>
</template>

<script>
import TheMapLayersDrawer from './TheMapLayersDrawer';
import TheMapToolbar from './TheMapToolbar';
import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';

export default {
    name: 'TheMapContainer',
    components: {
        TheMapLayersDrawer,
        TheMapToolbar
    },
    mixins: [
        MapContainerComponentStoreMx
    ],
    data() {
        return {
            zoom: 6,
            center: [0,0],
            rotation: 0,
            apiKey: this.$store.state.bingApiKey,
            $_ComponentStoreMx_cid: 'the-map-container'
        };
    },
    created() {
        this.$_MapContainerComponentStoreMx_currentBaseMap = this.$store.state.default.baseMap;
        this.$_MapContainerComponentStoreMx_currentBingImagerySet =  this.$store.state.default.bingImagerySet;
    },
};
</script>

<style scoped>

</style>