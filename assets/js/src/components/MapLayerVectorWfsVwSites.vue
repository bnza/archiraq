<template>
    <map-layer-vector-wfs
        :cid-p="CID"
        typename="archiraq:vw_site"
        :visible-p="true"
    />
</template>
<script>
import MapLayerVectorWfs from './MapLayerVectorWfs';
import ComponentStoreVisibleMx from '../mixins/ComponentStoreVisibleMx';
import {CID_MAP_LAYER_VECTOR_WFS_VW_SITES as CID} from '../utils/cids';

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
        CID: () => CID
    },
};
</script>
