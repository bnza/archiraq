<template>
    <map-layer-vector-wfs
        :cid-p="CID"
        :typename="typename"
        :visible-p="true"
    />
</template>
<script>
import MapLayerVectorWfs from './MapLayerVectorWfs';
import ComponentStoreVisibleMx from '../mixins/ComponentStoreVisibleMx';
import {CID_MAP_LAYER_VECTOR_WFS_VW_SITES as CID} from '../utils/cids';

export const SITE_POLY_ZOOM_UPPER_BOUND = 10;
export const SITE_POLY_WFS_TYPENAME = 'archiraq:vw_site_poly';
export const SITE_POINT_WFS_TYPENAME = 'archiraq:vw_site_point';

export default {
    name: CID,
    components: {
        MapLayerVectorWfs
    },
    mixins: [
        ComponentStoreVisibleMx
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
            //typename: SITE_POINT_WFS_TYPENAME
        };
    },
    computed: {
        CID: () => CID,
        typename() {
            return this.zoom > SITE_POLY_ZOOM_UPPER_BOUND ? SITE_POLY_WFS_TYPENAME : SITE_POINT_WFS_TYPENAME
        }
    },
/*    watch: {
        zoom: {
            handler(value) {
                if (value > SITE_POLY_ZOOM_UPPER_BOUND && this.typename !== SITE_POLY_WFS_TYPENAME) {
                    //Show polys
                    this.typename = SITE_POLY_WFS_TYPENAME;
                } else if (value <= SITE_POLY_ZOOM_UPPER_BOUND && this.typename !== SITE_POINT_WFS_TYPENAME) {
                    //Show points
                    this.typename = SITE_POINT_WFS_TYPENAME;
                }
            }
        }
    }*/
};
</script>
