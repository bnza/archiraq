<template>
    <map-layer-vector-wfs
        :cid-p="CID"
        :typename="typename"
        :visible-p="true"
        :filter="filter"
    />
</template>
<script>
import MapLayerVectorWfs from '@/components/MapLayerVectorWfs';
import ComponentStoreVisibleMx from '@/mixins/ComponentStoreVisibleMx';
import QueryMx from '@/mixins/QueryMx';
import {CID_MAP_LAYER_VECTOR_WFS_VW_SITES as CID} from '@/utils/cids';

export const SITE_POLY_ZOOM_UPPER_BOUND = 10;
export const SITE_POLY_WFS_TYPENAME = 'archiraq:vw_site_poly';
export const SITE_POINT_WFS_TYPENAME = 'archiraq:vw_site_point';

export default {
    name: CID,
    components: {
        MapLayerVectorWfs
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
                return this.getQueryFilter('vw-site');
            },
            set(value) {
                this.setQueryFilter({typename: 'vw-site', filter: value});
            }
        }
    },
    created() {
        this.filter = null;
    }
};
</script>
