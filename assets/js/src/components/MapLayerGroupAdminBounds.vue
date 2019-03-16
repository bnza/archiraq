<template>
    <div>
        <map-layer-vector-wfs-admin-bounds
            :cid-p="CID_ADMIN_BOUNDS_NATIONS"
            typename="archiraq:admbnd0"
            :visible-p="false"
        />
        <map-layer-vector-wfs-admin-bounds
            :cid-p="CID_ADMIN_BOUNDS_GOVERNORATES"
            typename="archiraq:admbnd1"
            :visible-p="false"
        />
        <map-layer-vector-wfs-admin-bounds
            :cid-p="CID_ADMIN_BOUNDS_DISTRICTS"
            typename="archiraq:admbnd2"
            :visible-p="false"
        />
    </div>
</template>

<script>

export const CID_ADMIN_BOUNDS_NATIONS = 'MapLayerVectorWfsAdminBoundsNations';
export const CID_ADMIN_BOUNDS_GOVERNORATES = 'MapLayerVectorWfsAdminBoundsGovernorates';
export const CID_ADMIN_BOUNDS_DISTRICTS = 'MapLayerVectorWfsAdminBoundsDistricts';

import MapLayerVectorWfsAdminBounds from './MapLayerVectorWfsAdminBounds';
export default {
    name: 'MapLayerGroupAdminBounds',
    components: {
        MapLayerVectorWfsAdminBounds
    },
    computed: {
        CID_ADMIN_BOUNDS_NATIONS: () => CID_ADMIN_BOUNDS_NATIONS,
        CID_ADMIN_BOUNDS_GOVERNORATES: () => CID_ADMIN_BOUNDS_GOVERNORATES,
        CID_ADMIN_BOUNDS_DISTRICTS: () => CID_ADMIN_BOUNDS_DISTRICTS
    }
};
</script>

<style scoped>

</style>
