<template>
    <vl-layer-vector
        :id="cid"
        :visible="visible"
    >
        <vl-source-vector
            ref="source"
            :url="urlFunction"
            :strategy-factory="loadingStrategyFactory"
            :loader-factory="loaderFactory"
            :typename="typename"
            :filter="filter"
            @fetchError="displaySnackbar"
        />
        <slot name="style" />
    </vl-layer-vector>
</template>

<script>

import {loadingBBox} from 'vuelayers/lib/ol-ext';
import {getBboxFeatureRequestXmlBody} from '../utils/wfs';
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
        },
        filter: {
            type: Object,
            default: null
        }
    },
    computed: {
        isCurrentLayer() {
            return !!this.cid
                    && this.mapContainerCurrentLayer === this.cid;
        },
    },
    watch: {
        typename() {
            this.$refs.source.refresh();
        },
        filter() {
            this.$refs.source.refresh();
        }
    },
    created() {
        this.visible = this.visibleP;
    },
    methods: {
        urlFunction (extent, resolution, projection) {
            return this.$store.state.geoserver.baseUrl + 'wfs';
        },
        loadingStrategyFactory () {
            // VueLayers.olExt available only in UMD build
            // in ES build it should be imported explicitly from 'vuelayers/lib/ol-ext'
            return loadingBBox;
        },
        loaderFactory(vm) {
            return function (extent, resolution, projection) {

                const setHeaders = (auth) => {
                    const reqHeaders = headers.setAuthorizationBasic(auth);
                    headers.setContentType('text/xml', reqHeaders);
                    return reqHeaders;
                };

                let axiosRequestConfig = {
                    method: 'post',
                    url: vm.$source.getUrl()(extent, resolution, projection),
                    data: getBboxFeatureRequestXmlBody(extent, resolution, projection, vm.$attrs.typename, vm.$attrs.filter),
                    headers: setHeaders(vm.$store.getters[`geoserver/auth/${GET_GUEST_AUTH}`])
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
    }
};
</script>

<style scoped>

</style>
