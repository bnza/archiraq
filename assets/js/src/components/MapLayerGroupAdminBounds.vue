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
            typename="archiraq:2_irq_governorate"
            :visible-p="false"
            geom-field="the_geom"
        />
        <map-layer-vector-wfs-admin-bounds
            :cid-p="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2"
            typename="archiraq:3_irq_districts"
            :visible-p="false"
            geom-field="the_geom"
        />
        <map-layer-vector-wfs-admin-bounds
            :cid-p="CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_3"
            typename="archiraq:4_irq_sub-districts"
            :visible-p="false"
            geom-field="the_geom"
        />
    </div>
</template>

<script>

import {
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_3,
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
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2,
        CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_3: () => CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_3
    }
};
</script>

<style scoped>

</style>
