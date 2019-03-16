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
import {CID as CID_THE_MAIN_NAVIGATION_DRAWER}  from './TheMainNavigationDrawer';
export const CID = 'TheMainToolbar';

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
