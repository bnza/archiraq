<template>
    <v-toolbar
        color="indigo"
        dark
        fixed
        app
    >
        <v-toolbar-side-icon
            @click.stop="componentStoreMx_mutation(
                STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP,
                {
                    cid: CID_THE_MAIN_NAVIGATION_DRAWER,
                    prop: 'visible'
                }
            )"
        />
        <v-toolbar-title>Application</v-toolbar-title>
    </v-toolbar>
</template>

<script>
import {
    CID_THE_MAIN_NAVIGATION_DRAWER,
    CID_THE_MAIN_TOP_TOOLBAR,
    STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP
} from '../utils/constants';
import ComponentsStoreMx from '../../src/mixins/ComponentsStoreMx';

export default {
    name: 'TheMainTopToolbar',
    mixins: [
        ComponentsStoreMx
    ],
    data() {
        return {
            componentStoreMx_cid: CID_THE_MAIN_TOP_TOOLBAR
        };
    },
    computed: {
        STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP: () => STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP,
        CID_THE_MAIN_NAVIGATION_DRAWER: () => CID_THE_MAIN_NAVIGATION_DRAWER
    }
};
</script>

<style scoped>

</style>
