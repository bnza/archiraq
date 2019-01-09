<template>
    <div>
        <slot name="toolbar" />
        <slot name="card" >

        </slot>
    </div>
</template>

<script>
import MapLayerVectorFeaturePropertiesCardMx from '../mixins/MapLayerVectorFeaturePropertiesPanelMx';
export default {
    name: 'MapLayerVectorWfsAdminBounds2FeaturePropertiesCard',
    mixins: [
        MapLayerVectorFeaturePropertiesCardMx
    ]
};
</script>

<style scoped>

</style>
