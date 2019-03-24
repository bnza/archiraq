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
                @fetchError="displaySnackbar"
            />
        </vl-layer-vector>
    </vl-interaction-select>
</template>

<script>
import { shiftKeyOnly, singleClick } from 'ol/events/condition';
import * as olExt from 'vuelayers/lib/ol-ext';
import {headers} from '../utils/http';
import {SET_OFF} from '../store/geoserver/mutations';
import {GET_GUEST_AUTH} from '../store/geoserver/auth/getters';
import {REQUEST} from '../store/client/actions';
import HttpClientMx from '../mixins/HttpClientMx';
import MapContainerComponentStoreMx from '../mixins/MapContainerComponentStoreMx';
import ComponentStoreVisibleMx from '../mixins/ComponentStoreVisibleMx';
import SnackbarComponentStoreMx from '../mixins/SnackbarComponentStoreMx';

export default {
    name: 'MapLayerVectorWfs',
    mixins: [
        MapContainerComponentStoreMx,
        ComponentStoreVisibleMx,
        HttpClientMx,
        SnackbarComponentStoreMx
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
            return !!this.cid
                    && this.mapContainerCurrentLayer === this.cid;
        }
    },
    watch: {
        isCurrentLayer: function (flag) {
            if (flag) {
                this.selectedFeatures = this.getProp('selectedFeatures');
            } else {
                this.selectedFeatures = [];
            }
        },
        visible: function (flag) {
            if (flag) {
                this.selectedFeatures = this.getProp('selectedFeatures');
            } else {
                this.selectedFeatures = [];
            }
        },
        selectedFeatures: function (features) {
            if (this.isCurrentLayer && this.visible) {
                this.setProp('selectedFeatures', features);
            }
        }
    },
    created() {
        this.visible = this.visibleP;
        this.setProp('selectedFeatures', this.selectedFeatures);
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
                const getUrl = vm.$source.getUrl();
                const url = getUrl(extent, resolution, projection);
                let axiosRequestConfig = {
                    method: 'get',
                    url: url,
                    headers: headers.setAuthorizationBasic(
                        vm.$store.getters[`geoserver/auth/${GET_GUEST_AUTH}`]
                    )
                };
                return vm.$store.dispatch(
                    `client/${REQUEST}`,
                    axiosRequestConfig
                ).then((response) => {
                    return response.data;
                }).then(function (data) {
                    if (!vm.$source) {
                        return [];
                    }
                    return vm.$source.getFormat().readFeatures(data, {
                        featureProjection: vm.viewProjection,
                        dataProjection: vm.resolvedDataProjection
                    });
                }).catch((error) => {
                    const color = 'error';
                    let text = 'Error: ';
                    if (!error.response && error.request) {
                        vm.$store.commit(`geoserver/${SET_OFF}`);
                        text += 'GeoServer does not respond. \n Please contact server administrator';
                    }
                    vm.$emit('fetchError', text, color);
                });
            };
        }
    },
};
</script>

<style scoped>

</style>
