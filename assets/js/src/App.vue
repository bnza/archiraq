<template>
    <v-app>
        <the-main-toolbar />
        <the-main-navigation-drawer />
        <v-content>
            <the-snack-bar />
            <v-container
                class="no-side-padding"
                fluid
            >
                <v-layout
                    align-space-between
                    justify-center
                    column
                >
                    <transition>
                        <keep-alive>
                            <router-view name="map" />
                        </keep-alive>
                    </transition>
                    <router-view />
                </v-layout>
            </v-container>
        </v-content>
        <the-main-footer />
    </v-app>
</template>

<script>
import {SET_ENV_DATA} from './store/actions';
import TheMainNavigationDrawer from './components/TheMainNavigationDrawer';
import TheMainToolbar from './components/TheMainToolbar';
import TheMainFooter from './components/TheMainFooter';
import TheSnackBar from './components/TheSnackbar';

export default {
    name: 'App',
    components: {
        TheMainNavigationDrawer,
        TheMainToolbar,
        TheMainFooter,
        TheSnackBar
    },
    beforeCreate: function () {
        this.$store.dispatch(SET_ENV_DATA, window.envData).then(() => {
            delete window.envData;
            document.getElementById('env-data').remove();
        });
    }
};
</script>

<style scoped>
    .no-side-padding {
        padding: 0 0 24px 0;
    }
</style>

