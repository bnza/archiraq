<template>
    <div>
        <map-layer-vector-wfs
            :cid-p="CID"
            :typename="typename"
            :visible-p="true"
            :filter="filter"
        >
            <vl-style-box slot="style">
                <vl-style-circle :radius="3">
                    <vl-style-stroke
                        :width="1"
                        color="white"
                    />
                    <vl-style-fill color="rgb(255,152,0.5)" />
                </vl-style-circle>
                <vl-style-stroke
                    color="#FF9800"
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
import MapLayerVectorWfs from '@/components/MapLayerVectorWfs';
import VwSitePopupDataCard from '@/components/DataCard/Interaction/VwSitePopupDataCard';
import ComponentStoreVisibleMx from '@/mixins/ComponentStoreVisibleMx';
import QueryMx from '@/mixins/QueryMx';
import {CID_MAP_LAYER_VECTOR_WFS_VW_SITES as CID, QUERY_TYPENAME_VW_SITES} from '@/utils/cids';

export const SITE_POLY_ZOOM_UPPER_BOUND = 10;
export const SITE_POLY_WFS_TYPENAME = 'archiraq:vw_site_poly';
export const SITE_POINT_WFS_TYPENAME = 'archiraq:vw_site_point';

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
        zoom: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            cid: CID,
        };
    },
    computed: {
        CID: () => CID,
        typename() {
            return this.zoom > SITE_POLY_ZOOM_UPPER_BOUND ? SITE_POLY_WFS_TYPENAME : SITE_POINT_WFS_TYPENAME;
        },
        filter: {
            get() {
                return this.getQueryFilter(QUERY_TYPENAME_VW_SITES);
            },
            set(filter) {
                this.setQueryFilter(filter);
            }
        }
    },
    created() {
        this.filter = null;
    },
    methods: {
        getQueryTypeName() {
            return QUERY_TYPENAME_VW_SITES;
        },
    }
};
</script>
