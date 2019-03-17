<template>
    <v-toolbar
        color="indigo"
        dark
        app
        flat
    >
        <v-toolbar-side-icon
            data-test="the-main-toolbar--side-icon"
            @click.stop="toggleMainNavigationDrawerVisibility"
        />
        <v-toolbar-title>Archiraq</v-toolbar-title>
    </v-toolbar>
</template>

<script>
import ComponentsStoreMx from '../mixins/ComponentsStoreMx';
import {TOGGLE_COMPONENT_PROP} from '../store/components/mutations';
import {CID_THE_MAIN_TOOLBAR as CID, CID_THE_MAIN_NAVIGATION_DRAWER} from '../utils/cids';

export default {
    name: CID,
    mixins: [
        ComponentsStoreMx
    ],
    data() {
        return {
            cid: CID
        };
    },
    methods: {
        toggleMainNavigationDrawerVisibility() {
            this[TOGGLE_COMPONENT_PROP]({cid: CID_THE_MAIN_NAVIGATION_DRAWER, prop: 'visible'});
        }
    }
};
</script>
