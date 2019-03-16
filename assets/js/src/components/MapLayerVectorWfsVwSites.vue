<template>
    <map-layer-vector-wfs
        :cid-p="CID_MAP_LAYER_VECTOR_WFS_VW_SITES"
        typename="archiraq:vw_site"
        :visible-p="true"
    />
</template>
<script>
import MapLayerVectorWfs from './MapLayerVectorWfs';
import ComponentStoreVisibleMx from '../mixins/ComponentStoreVisibleMx';

export const CID = 'MapLayerVectorWfsVwSites';
export const CID_MAP_LAYER_VECTOR_WFS_VW_SITES = CID;

export default {
    name: CID,
    components: {
        MapLayerVectorWfs
    },
    mixins: [
        ComponentStoreVisibleMx
    ],
    data() {
        return {
            cid: CID
        };
    },
    computed: {
        CID_MAP_LAYER_VECTOR_WFS_VW_SITES: () => CID
    },
};
</script>
