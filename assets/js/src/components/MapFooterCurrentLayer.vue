<template>
    <v-flex
        xs6
        md4
        lg3
    >
        {{ mapContainerCurrentLayer }}
    </v-flex>
</template>

<script>
import MapContainerComponentStoreMx from '../mixins/MapContainerComponentStoreMx';

export default {
    name: 'MapFooterCurrentLayer',
    mixins: [
        MapContainerComponentStoreMx
    ]
};
</script>

<style scoped>

</style>
