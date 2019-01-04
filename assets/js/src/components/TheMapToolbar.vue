<template>
    <v-toolbar
        flat
        dense
    >
        <v-toolbar-side-icon
            data-cy="the-map-toolbar-left-side-icon"
            @click.stop="componentStoreMx_mutation(
                STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP,
                {
                    cid: CID_THE_MAP_LAYERS_DRAWER,
                    prop: 'visible'
                }
            )"
        />
        <v-toolbar-title>Title</v-toolbar-title>
    </v-toolbar>
</template>

<script>
import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';
import {
    CID_THE_MAP_LAYERS_DRAWER,
    STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP
} from '../utils/constants';

export default {
    name: 'TheMapToolbar',
    mixins: [
        MapContainerComponentStoreMx
    ],
    computed: {
        STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP: () => STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP,
        CID_THE_MAP_LAYERS_DRAWER: () => CID_THE_MAP_LAYERS_DRAWER
    }
};
</script>

<style scoped>

</style>
