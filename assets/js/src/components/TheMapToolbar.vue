<template>
    <v-toolbar
        flat
        dense
    >
        <v-toolbar-side-icon
            :data-test="DT_THE_MAP_TOOLBAR_LEFT_SIDE_ICON"
            @click.stop="componentStoreMx_mutation(
                STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP,
                {
                    cid: CID_THE_MAP_LAYERS_DRAWER,
                    prop: 'visible'
                }
            )"
        />
        <v-toolbar-title>Title</v-toolbar-title>
        <v-spacer />
        <v-btn
            :data-test="DT_THE_MAP_TOOLBAR_PROPERTIES_BUTTON"
            icon
            @click.stop="componentStoreMx_mutation(
                STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP,
                {
                    cid: CID_THE_MAP_PROPERTIES_DRAWER,
                    prop: 'visible'
                }
            )"
        >
            <v-icon>view_list</v-icon>
        </v-btn>
    </v-toolbar>
</template>

<script>
import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';
import {
    CID_THE_MAP_PROPERTIES_DRAWER,
    CID_THE_MAP_LAYERS_DRAWER,
    STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP,
    DT_THE_MAP_TOOLBAR_LEFT_SIDE_ICON,
    DT_THE_MAP_TOOLBAR_PROPERTIES_BUTTON
} from '../utils/constants';

export default {
    name: 'TheMapToolbar',
    mixins: [
        MapContainerComponentStoreMx
    ],
    computed: {
        STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP: () => STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP,
        CID_THE_MAP_LAYERS_DRAWER: () => CID_THE_MAP_LAYERS_DRAWER,
        CID_THE_MAP_PROPERTIES_DRAWER: () => CID_THE_MAP_PROPERTIES_DRAWER,
        DT_THE_MAP_TOOLBAR_LEFT_SIDE_ICON: () => DT_THE_MAP_TOOLBAR_LEFT_SIDE_ICON,
        DT_THE_MAP_TOOLBAR_PROPERTIES_BUTTON: () => DT_THE_MAP_TOOLBAR_PROPERTIES_BUTTON
    }
};
</script>

<style scoped>

</style>
