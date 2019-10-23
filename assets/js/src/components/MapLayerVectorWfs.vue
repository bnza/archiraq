<template>
    <vl-layer-vector
        :id="cid"
        :visible="visible"
    >
        <vl-source-vector
            ref="source"
            url="no-need"
            :strategy-factory="loadingStrategyFactory"
            :loader-factory="loaderFactory"
            :typename="typename"
            :filter="filter"
            @fetchError="displaySnackbar"
        />
        <slot name="style" />
        <app-interaction-select
            v-if="isCurrentLayer"
            :layer-cid="cid"
        >
            <template
                slot-scope="props"
            >
                <slot
                    :feature="props.feature"
                    name="select"
                />
            </template>
        </app-interaction-select>
    </vl-layer-vector>
</template>

<script>

import {loadingBBox} from 'vuelayers/lib/ol-ext';
import {addBboxFilter} from '../utils/wfs';
import {headers} from '@/utils/http';
import {SET_OFF} from '@/store/geoserver/mutations';
import AppInteractionSelect from '@/components/DataCard/Interaction/AppInteractionSelect';
import WfsGetFeatureMx from '@/mixins/WfsGetFeatureMx';
import MapContainerComponentStoreMx from '@/mixins/MapContainerComponentStoreMx';
import ComponentStoreVisibleMx from '@/mixins/ComponentStoreVisibleMx';
import SnackbarComponentStoreMx from '@/mixins/SnackbarComponentStoreMx';

export default {
    name: 'MapLayerVectorWfs',
    components: {
        AppInteractionSelect
    },
    mixins: [
        MapContainerComponentStoreMx,
        ComponentStoreVisibleMx,
        WfsGetFeatureMx,
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
        },
        refresh: {
            type: Boolean,
            default: false
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
            this.refreshSource();
        },
        filter() {
            this.refreshSource();
        },
        refresh(flag) {
            if (flag) {
                this.refreshSource().then(() => {
                    this.$emit('update:refresh', false);
                });
            }
        }
    },
    created() {
        this.visible = this.visibleP;
    },
    methods: {
        refreshSource() {
            return this.$refs.source.refresh();
        },
        loadingStrategyFactory () {
            // VueLayers.olExt available only in UMD build
            // in ES build it should be imported explicitly from 'vuelayers/lib/ol-ext'
            return loadingBBox;
        },
        loaderFactory(vm) {
            const typename = this.typename;
            const performWfsGetFeatureRequest = this.performWfsGetFeatureRequest;
            return function (extent, resolution, projection) {

                let reqHeaders = headers.setContentType('application/json');
                let filter = addBboxFilter({extent}, vm.filter);
                let config = {
                    typename,
                    filter,
                    propertyName: 'id,geom'
                };

                return performWfsGetFeatureRequest(config, reqHeaders).then(
                    (response) => {
                        return vm.$source.getFormat().readFeatures(response.data, {
                            featureProjection: vm.viewProjection,
                            dataProjection: vm.resolvedDataProjection
                        });
                    }
                ).catch((error) => {
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
