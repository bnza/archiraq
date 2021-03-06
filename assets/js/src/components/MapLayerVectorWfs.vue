<template>
    <vl-layer-vector
        :id="cid"
        :visible="visible"
    >
        <vl-source-vector
            ref="source"
            url="no"
            :strategy-factory="loadingStrategyFactory"
            :loader-factory="loaderFactory"
            :typename="typename"
            :filter="filter"
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
import {getExtentFromWfsGetFeatures} from '@/utils/ol';
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
        keyField: {
            type: String,
            default: 'id'
        },
        geomField: {
            type: String,
            default: 'geom'
        },
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
        extent: {
            get() {
                return this.getProp('extent');
            },
            set(value) {
                this.setProp('extent', value);
            }
        },
        unfilteredTotalFeatureNumber: {
            get() {
                return this.getProp('unfiltered-total-feature-number');
            },
            set(value) {
                this.setProp('unfiltered-total-feature-number', value);
            }
        }
    },
    watch: {
        typename() {
            this.refreshSource();
        },
        filter() {
            this.refreshSource();
            this.setExtent();
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
    mounted() {
        this.setTotalFeatureNumber();
        this.setExtent();
    },
    methods: {
        refreshSource() {
            this.$refs.source.refresh();
            //return this.$refs.source.scheduleRecreate(); //vuelayers >0.11.4
        },
        loadingStrategyFactory () {
            // VueLayers.olExt available only in UMD build
            // in ES build it should be imported explicitly from 'vuelayers/lib/ol-ext'
            return loadingBBox;
        },
        loaderFactory(vectorSourceComponent) {
            const vectorLayerComponent = this;
            return function (extent, resolution, projection) {

                let reqHeaders = headers.setContentType('application/json');
                let filter = addBboxFilter({extent, geometryName: vectorLayerComponent.geomField}, vectorLayerComponent.filter);
                let config = {
                    typename: vectorLayerComponent.typename,
                    filter,
                    propertyName: `${vectorLayerComponent.keyField},${vectorLayerComponent.geomField}`
                };


                return vectorLayerComponent.performWfsGetFeatureRequest(config, reqHeaders).then(
                    (response) => {
                        if (response.data && response.data.exceptions) {
                            const error = new Error();
                            error.errorMessages = response.data.exceptions.map(e => e.text).join(';');
                            throw error;
                        }
                        return vectorSourceComponent.$source.getFormat().readFeatures(response.data, {
                            featureProjection: vectorSourceComponent.viewProjection,
                            dataProjection: vectorSourceComponent.resolvedDataProjection
                        });
                        //return response.data; //vuelayers >0.11.4
                    }
                ).catch((error) => {
                    const color = 'error';
                    let text = 'Error: ';
                    if (!error.response && error.request) {
                        vectorLayerComponent.$store.commit(`geoserver/${SET_OFF}`);
                        text += 'GeoServer does not respond. \n Please contact server administrator';
                    } else if (error.errorMessages) {
                        text += error.errorMessages;
                    }
                    vectorLayerComponent.displaySnackbar(text, color);
                });
            };
        },
        setTotalFeatureNumber() {
            let config = {
                typename: this.typename,
                filter: this.filter,
                propertyName: 'id'
            };
            return this.performWfsGetFeatureRequest(config).then(
                (response) => {
                    this.unfilteredTotalFeatureNumber = response.data.totalFeatures;
                }
            );
        },
        setExtent() {
            let config = {
                typename: this.typename,
                filter: this.filter,
                propertyName: this.geomField
            };

            return this.performWfsGetFeatureRequest(config).then(
                (response) => {
                    this.extent = getExtentFromWfsGetFeatures(response.data);
                }
            );
        }
    }
};
</script>

<style scoped>

</style>
