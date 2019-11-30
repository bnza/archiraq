<template>
    <div>
        <map-layer-vector-wfs-admin-bounds
            key-field="code"
            :cid-p="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0"
            typename="archiraq:admbnd0"
            :visible-p="false"
        />
        <map-layer-vector-wfs-admin-bounds
            :cid-p="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1"
            typename="archiraq:admbnd1"
            :visible-p="false"
        />
        <map-layer-vector-wfs-admin-bounds
            :cid-p="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2"
            typename="archiraq:admbnd2"
            :visible-p="false"
        />
    </div>
</template>

<script>

import {
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2,
    CID_MAP_LAYER_GROUP_ADMIN_BOUNDS as CID
} from '../utils/cids';


import MapLayerVectorWfsAdminBounds from './MapLayerVectorWfsAdminBounds';

export default {
    name: CID,
    components: {
        MapLayerVectorWfsAdminBounds
    },
    computed: {
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0,
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1,
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2
    }
};
</script>

<style scoped>

</style>
