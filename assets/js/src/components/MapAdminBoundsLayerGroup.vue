<template>
    <vl-interaction-select
        :features.sync="selectedFeatures"
    >
        <map-layer-vector-wfs-admin-bounds
            cid-p="archiraq_admbnd0_wfs"
            typename="archiraq:admbnd0"
            :visible-p="false"
        />
        <map-layer-vector-wfs-admin-bounds
            cid-p="archiraq_admbnd1_wfs"
            typename="archiraq:admbnd1"
            :visible-p="false"
        />
        <map-layer-vector-wfs-admin-bounds
            cid-p="archiraq_admbnd2_wfs"
            typename="archiraq:admbnd2"
            :visible-p="true"
        />
    </vl-interaction-select>
</template>

<script>
import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';
import MapLayerVectorWfsAdminBounds from './MapLayerVectorWfsAdminBounds';
export default {
    name: 'MapAdminBoundsLayerGroup',
    components: {
        MapLayerVectorWfsAdminBounds
    },
    mixins: [
        MapContainerComponentStoreMx
    ],
    data() {
        return {
            selectedFeatures: []
        };
    },
    computed: {
        isCurrentLayer() {
            return !!this.componentStoreMx_cid
                && this.mapContainerComponentStoreMx_currentLayer === this.componentStoreMx_cid;
        }
    },
    watch: {
        selectedFeatures: function (features) {
            if (this.$_layerCids.includes(this.mapContainerComponentStoreMx_currentLayer)) {
                this.mapContainerComponentStoreMx_selectedFeatures = features;
            }
        }
    },
    created() {
        this.$_layerCids = ['archiraq_admbnd0_wfs', 'archiraq_admbnd1_wfs', 'archiraq_admbnd2_wfs'];
    }
};
</script>

<style scoped>

</style>