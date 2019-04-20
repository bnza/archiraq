<template>
    <v-flex
        xs6
        md4
        lg3
    >
        {{ mapContainerPointerCoordX.toFixed(6) }},{{ mapContainerPointerCoordY.toFixed(6) }}
    </v-flex>
</template>

<script>
import MapContainerComponentStoreMx from '../mixins/MapContainerComponentStoreMx';

export default {
    name: 'MapFooterPointerCoords',
    mixins: [
        MapContainerComponentStoreMx
    ]
};
</script>

<style scoped>

</style>
