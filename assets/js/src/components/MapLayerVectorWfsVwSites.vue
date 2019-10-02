<template>
    <div>
        <map-layer-vector-wfs
            :cid-p="baseTypename"
            :typename="typename"
            :visible-p="true"
            :filter="filter"
            :refresh.sync="refresh"
        >
            <vl-style-box slot="style">
                <vl-style-circle :radius="3">
                    <vl-style-stroke
                        :width="1"
                        color="white"
                    />
                    <vl-style-fill :color="featureColor" />
                </vl-style-circle>
                <vl-style-stroke
                    :color="featureColor"
                    :width="3"
                />
                <vl-style-fill color="rgba(255,255,255,0.5)" />
            </vl-style-box>
            <template
                slot="select"
                slot-scope="props"
            >
                <vw-site-popup-data-card :feature="props.feature" />
            </template>
        </map-layer-vector-wfs>
    </div>
</template>
<script>
import {kebabCase} from 'lodash';
import MapLayerVectorWfs from '@/components/MapLayerVectorWfs';
import VwSitePopupDataCard from '@/components/DataCard/Interaction/VwSitePopupDataCard';
import ComponentStoreVisibleMx from '@/mixins/ComponentStoreVisibleMx';
import QueryMx from '@/mixins/QueryMx';
import {CID_MAP_LAYER_VECTOR_WFS_VW_SITES as CID} from '@/utils/cids';

export const SITE_POLY_ZOOM_UPPER_BOUND = 10;

export default {
    name: CID,
    components: {
        MapLayerVectorWfs,
        VwSitePopupDataCard
    },
    mixins: [
        ComponentStoreVisibleMx,
        QueryMx
    ],
    props: {
        featureColor: {
            type: String,
            required: true
        },
        baseTypenamePrefix: {
            type: String,
            default: 'archiraq'
        },
        baseTypename: {
            type: String,
            required: true
        },
        zoom: {
            type: Number,
            required: true
        }
    },
    computed: {
        queryTypename() {
            return kebabCase(this.baseTypename);
        },
        typename() {
            const suffix = this.zoom > SITE_POLY_ZOOM_UPPER_BOUND
                ? 'poly'
                : 'point';
            return `${this.baseTypenamePrefix}:${this.baseTypename}_${suffix}`;
        },
        filter: {
            get() {
                return this.getQueryFilter(this.queryTypename);
            },
            set(filter) {
                this.setQueryFilterFn({
                    typename: this.queryTypename,
                    filter
                });
            }
        },
        refresh: {
            get() {
                return this.getProp('refresh');
            },
            set(value) {
                this.setProp('refresh', value);
            }
        }
    },
    created() {
        this.filter = null;
        this.refresh = false;
    }
};
</script>
