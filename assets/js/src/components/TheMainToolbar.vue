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
        <v-spacer />
        <v-toolbar-title
            v-if="authIsAuthenticated"
            style="font-size: 1rem;"
        >
            {{ authGetUsername }}
        </v-toolbar-title>
        <v-toolbar-items>
            <user-toolbar-list-action-menu />
        </v-toolbar-items>
    </v-toolbar>
</template>

<script>
import ComponentsStoreMx from '../mixins/ComponentsStoreMx';
import AuthMx from '../mixins/AuthMx';
import UserToolbarListActionMenu from './UserToolbarListActionMenu';
import {TOGGLE_COMPONENT_PROP} from '../store/components/mutations';
import {CID_THE_MAIN_TOOLBAR as CID, CID_THE_MAIN_NAVIGATION_DRAWER} from '../utils/cids';

export default {
    name: CID,
    components: {UserToolbarListActionMenu},
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
            this[TOGGLE_COMPONENT_PROP]({cid: CID_THE_MAIN_NAVIGATION_DRAWER, prop: 'visible'});
        }
    }
};
</script>
