<template>
    <vl-interaction-select
        :features.sync="selectedFeatures"
        :condition="selectCondition"
        :toggle-condition="toggleCondition"
    >
        <vl-layer-vector
            :visible="visible"
        >
            <vl-source-vector
                :url="urlFunction"
                :strategy-factory="loadingStrategyFactory"
                :loader-factory="loaderFactory"
            />
        </vl-layer-vector>
    </vl-interaction-select>
</template>

<script>
import { shiftKeyOnly, singleClick } from 'ol/events/condition';
import * as olExt from 'vuelayers/lib/ol-ext';
import { fetch } from 'whatwg-fetch';
import {headers} from '../utils/http';
import {STORE_M_GS_AUTH_G_GUEST_AUTH} from '../utils/constants';
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
    data() {
        return {
            selectedFeatures: []
        };
    },
    computed: {
        isCurrentLayer() {
            return !!this.componentStoreMx_cid
                    && this.mapContainerComponentStoreMx_currentLayer === this.componentStoreMx_cid;
        },
        visible: {
            get() {
                return this.componentStoreMx_getStoreProp('visible');
            },
            set(value) {
                this.componentStoreMx_setStoreProp('visible', !!value);
            }
        }
    },
    watch: {
        visible: function (flag) {
            if (!flag) {
                this.selectedFeatures = [];
            }
        },
        selectedFeatures: function (features) {
            if (this.isCurrentLayer) {
                this.mapContainerComponentStoreMx_selectedFeatures = features;
            }
        }
    },
    created() {
        this.visible = this.visibleP;
    },
    methods: {
        selectCondition(olMapBrowserEvent)  {
            return this.isCurrentLayer
                    && singleClick(olMapBrowserEvent);
        },
        toggleCondition(olMapBrowserEvent)  {
            return this.isCurrentLayer
                    && shiftKeyOnly(olMapBrowserEvent);
        },
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
                        vm.$store.getters[`geoserver/auth/${STORE_M_GS_AUTH_G_GUEST_AUTH}`]
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
