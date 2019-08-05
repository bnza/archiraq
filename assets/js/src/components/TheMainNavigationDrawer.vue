<template>
    <v-navigation-drawer
        v-model="visible"
        data-test="the-main-navigation-drawer--aside"
        clipped
        app
    >
        <v-list dense>
            <slot />
            <v-list-group
                v-if="authHasRoleEditor"
                prepend-icon="add_circle_outline"
                no-action
            >
                <v-list-tile
                    slot="activator"
                >
                    <v-list-tile-content>
                        <v-list-tile-title>Upload contribute</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile
                    @click="$router.push('/contribute/upload/survey/zip-shapefile')"
                >
                    <v-list-tile-content>
                        <v-list-tile-title>Survey</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile
                    @click="$router.push('/contribute/upload/remote-sensing/zip-shapefile')"
                >
                    <v-list-tile-content>
                        <v-list-tile-title>Remote Sensing</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list-group>
            <user-auth-list-tile />
        </v-list>
    </v-navigation-drawer>
</template>

<script>
import AuthMx from '@/mixins/AuthMx';
import ComponentStoreVisibleMx from '../mixins/ComponentStoreVisibleMx';
import UserAuthListTile from './UserAuthListTile';
import {CID_THE_MAIN_NAVIGATION_DRAWER as CID} from '../utils/cids';

export default {
    name: CID,
    components: {
        UserAuthListTile
    },
    mixins: [
        AuthMx,
        ComponentStoreVisibleMx
    ],
    data() {
        return {
            cid: CID
        };
    }
};
</script>
