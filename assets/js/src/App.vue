<template>
    <v-app>
        <the-main-navigation-drawer

        >
        </the-main-navigation-drawer>
        <the-main-top-toolbar
                cid-p="the-main-top-toolbar"
        >
        </the-main-top-toolbar>
        <v-content>
            <v-container fluid>
                <v-layout align-space-between justify-center column>
                        <router-view/>
                        <transition>
                            <keep-alive>
                                <router-view name="map"/>
                            </keep-alive>
                        </transition>
                </v-layout>
            </v-container>
        </v-content>
        <the-main-footer/>
    </v-app>
</template>

<script>
    import TheMapContainer from './components/TheMapContainer'
    import TheMainFooter from './components/TheMainFooter'
    import TheMainNavigationDrawer from './components/TheMainNavigationDrawer'
    import TheMainTopToolbar from './components/TheMainTopToolbar'
    import STORE from './store/store-funcs'

    export default {
        name: "App",
        components: {
            TheMapContainer,
            TheMainFooter,
            TheMainNavigationDrawer,
            TheMainTopToolbar
        },
        beforeCreate: function () {
            this.$store.commit(STORE.MUTATIONS.SET_BING_API_KEY, window.envData.bingApiKey)
            delete window.envData
            document.getElementById('env-data').remove()
        }
    }
</script>

<style scoped>

</style>