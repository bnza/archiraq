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
        <router-link id="toolbarHomeLink" to="/">
            <v-toolbar-title>FloodPlains</v-toolbar-title>
        </router-link>
        <v-spacer />
        <v-toolbar-items class="hidden-xs-only">
            <slot />
        </v-toolbar-items>
    </v-toolbar>
</template>

<script>
import ComponentsStoreMx from '@/mixins/ComponentsStoreMx';
import AuthMx from '@/mixins/AuthMx';
import {CID_THE_MAIN_TOOLBAR as CID, CID_THE_MAIN_NAVIGATION_DRAWER} from '@/utils/cids';

export default {
    name: CID,
    mixins: [
        AuthMx,
        ComponentsStoreMx
    ],
    data() {
        return {
            cid: CID
        };
    },
    methods: {
        toggleMainNavigationDrawerVisibility() {
            this.componentsToggleComponentProp({cid: CID_THE_MAIN_NAVIGATION_DRAWER, prop: 'visible'});
        }
    }
};
</script>

<style>
    #toolbarHomeLink {
        color: white;
        text-decoration: none;
    }
</style>
