<template>
    <v-app>
        <the-main-navigation-drawer
                cid-p="the-main-navigation-drawer"
        >
        </the-main-navigation-drawer>
        <the-main-top-toolbar
                cid-p="the-main-top-toolbar"
        >
        </the-main-top-toolbar>
        <v-content>
            <v-container fluid fill-height>
                <router-view/>
                <transition>
                    <keep-alive>
                        <router-view name="map"/>
                    </keep-alive>
                </transition>
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

    export default {
        name: "App",
        components: {
            TheMapContainer,
            TheMainFooter,
            TheMainNavigationDrawer,
            TheMainTopToolbar
        }
    }
</script>

<style scoped>

</style>