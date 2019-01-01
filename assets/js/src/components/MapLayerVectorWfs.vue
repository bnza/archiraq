<template>
    <vl-layer-vector
        :visible="visible"
    >
        <vl-source-vector
            :url="urlFunction"
            :strategy-factory="loadingStrategyFactory"
            :loader-factory="loaderFactory"
        />
    </vl-layer-vector>
</template>

<script>
import * as olExt from 'vuelayers/lib/ol-ext';
import { fetch } from 'whatwg-fetch';
import {headers} from '../utils/http';
import {GETTERS as AUTH_GETTERS} from '../store/geoserver/auth/getters';
import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';

export default {
    name: 'MapLayerVectorWfs',
    mixins: [
        MapContainerComponentStoreMx
    ],
    props: {
        typename: {
            type: String,
            required: true
        },
        visibleP: {
            type: Boolean,
            default: true
        }
    },
    computed: {
        visible: {
            get() {
                return this.componentStoreMx_getStoreProp('visible');
            },
            set(value) {
                this.componentStoreMx_setStoreProp('visible', !!value);
            }
        }
    },
    created() {
        this.visible = this.visibleP;
    },
    methods: {
        urlFunction (extent, resolution, projection) {
            return this.$store.state.geoserver.baseUrl + 'wfs?service=WFS&' +
                'version=1.1.0&request=GetFeature&typename=' + this.typename + '&' +
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