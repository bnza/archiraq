<template>
    <v-card flat>
        <the-map-toolbar />
        <vl-map
            ref="map"
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
            <vl-layer-vector
                id="prova"
                :visible="true"
            >
                <vl-source-vector
                    :url="urlFunction"
                    :strategy-factory="loadingStrategyFactory"
                    :loader-factory="loaderFactory"
                />
            </vl-layer-vector>
            <the-map-layers-drawer />
        </vl-map>
    </v-card>
</template>

<script>
import * as olExt from 'vuelayers/lib/ol-ext';
import { fetch } from 'whatwg-fetch';
import {headers} from '../utils/http';
import {GETTERS as AUTH_GETTERS} from '../store/geoserver/auth/getters';
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
            center: [0, 0],
            rotation: 0,
            apiKey: this.$store.state.bingApiKey,
            componentStoreMx_cid: 'the-map-container'
        };
    },
    created() {
        this.mapContainerComponentStoreMx_currentBaseMap = this.$store.state.default.baseMap;
        this.mapContainerComponentStoreMx_currentBingImagerySet =  this.$store.state.default.bingImagerySet;
    },
    mounted () {
    // get vl-map by ref="map" and await ol.Map creation
        this.$refs.map.$createPromise.then(() => {
            this.center = [ 47.44, 33.37];
        });
    },
    methods: {
        urlFunction (extent, resolution, projection) {
            return this.$store.state.geoserver.baseUrl + 'wfs?service=WFS&' +
                'version=1.1.0&request=GetFeature&typename=archiraq:iraq_admbnda_adm0&' +
                'outputFormat=application/json&srsname=' + projection + '&' +
                'bbox=' + extent.join(',') + ',' + projection;
        },
        loadingStrategyFactory () {
            // VueLayers.olExt available only in UMD build
            // in ES build it should be imported explicitly from 'vuelayers/lib/ol-ext'
            return olExt.loadingBBox;
        },
        loaderFactory(vm) {
            return function (extent, resolution, projection) {
                let url = vm.$source.getUrl();
                url = url(extent, resolution, projection);
                return fetch(url, {
                    credentials: 'same-origin',
                    mode: 'cors',
                    headers: headers.setAuthorizationBasic(
                        vm.$store.getters[`geoserver/auth/${AUTH_GETTERS.GET_GUEST_AUTH}`]
                    )
                }).then(function (response) {
                    return response.text();
                }).then(function (text) {
                    if (!vm.$source) {
                        return [];
                    }

                    return vm.$source.getFormat().readFeatures(text, {
                        featureProjection: vm.viewProjection,
                        dataProjection: vm.resolvedDataProjection
                    });
                });
            };
        }
    },
};
</script>

<style scoped>

</style>