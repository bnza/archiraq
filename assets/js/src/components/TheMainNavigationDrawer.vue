<template>
    <v-navigation-drawer
        v-model="visible"
        data-test="the-main-navigation-drawer--aside"
        clipped
        app
    >
        <v-list dense>
            <slot />
            <user-auth-list-tile />
        </v-list>
    </v-navigation-drawer>
</template>

<script>
import ComponentStoreVisibleMx from '../mixins/ComponentStoreVisibleMx';
import UserAuthListTile from './UserAuthListTile';
import {CID_THE_MAIN_NAVIGATION_DRAWER as CID} from '../utils/cids';

export default {
    name: CID,
    components: {
        UserAuthListTile
    },
    mixins: [
        ComponentStoreVisibleMx
    ],
    data() {
        return {
            cid: CID
        };
    }
};
</script>
