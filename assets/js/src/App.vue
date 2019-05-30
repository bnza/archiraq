<template>
    <v-app>
        <the-main-toolbar>
            <router-view name="toolbar" />
        </the-main-toolbar>
        <the-main-navigation-drawer>
            <router-view name="drawer" />
        </the-main-navigation-drawer>
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
                    <router-view name="modal" />
                </v-layout>
            </v-container>
        </v-content>
        <the-main-footer>
            <router-view name="footer" />
        </the-main-footer>
    </v-app>
</template>

<script>
import Cookies from 'js-cookie';
import {SET_ENV_DATA} from './store/actions';
import TheMainNavigationDrawer from './components/TheMainNavigationDrawer';
import TheMainToolbar from './components/TheMainToolbar';
import TheMainFooter from './components/TheMainFooter';
import TheSnackBar from './components/TheSnackbar';

const setEnvData = ($store) => {
    $store.dispatch(SET_ENV_DATA, getEnvData()).then(() => {
        clearEnvData();
    });
};

/**
 *
 * @return {{bingApiKey, geoServer}|*|{}}
 */
const getEnvData = () => {
    const envData = JSON.parse(Cookies.get('env-data'));
    envData.xsrfToken = Cookies.get('xsrf-token');
    return envData;
};

const clearEnvData = () =>  {
    Cookies.remove('env-data');
    Cookies.remove('xsrf-token');
};

export default {
    name: 'App',
    components: {
        TheMainNavigationDrawer,
        TheMainToolbar,
        TheMainFooter,
        TheSnackBar
    },
    beforeCreate: function () {
        setEnvData(this.$store);
    }
};
</script>

<style scoped>
    .no-side-padding {
        padding: 0 0 24px 0;
    }
</style>

