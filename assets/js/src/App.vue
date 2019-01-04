<template>
    <v-app>
        <the-main-navigation-drawer />
        <the-main-top-toolbar
            cid-p="the-main-top-toolbar"
        />
        <v-content>
            <v-container fluid>
                <v-layout
                    align-space-between
                    justify-center
                    column
                >
                    <router-view />
                    <transition>
                        <keep-alive>
                            <router-view name="map" />
                        </keep-alive>
                    </transition>
                </v-layout>
            </v-container>
        </v-content>
        <the-main-footer />
    </v-app>
</template>

<script>
import TheMainFooter from './components/TheMainFooter';
import TheMainNavigationDrawer from './components/TheMainNavigationDrawer';
import TheMainTopToolbar from './components/TheMainTopToolbar';
import {STORE_M_ROOT_A_ENV_DATA} from './utils/constants';

export default {
    name: 'App',
    components: {
        TheMainFooter,
        TheMainNavigationDrawer,
        TheMainTopToolbar
    },
    beforeCreate: function () {
        this.$store.dispatch(STORE_M_ROOT_A_ENV_DATA, window.envData).then(() => {
            delete window.envData;
            document.getElementById('env-data').remove();
        });
    }
};
</script>

<style scoped>

</style>
