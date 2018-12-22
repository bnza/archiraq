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
            <p>It works</p>
        </v-content>
    </v-app>
</template>

<script>
    import TheMainNavigationDrawer from './components/TheMainNavigationDrawer'
    import TheMainTopToolbar from './components/TheMainTopToolbar'
    export default {
        name: "App",
        components: {
            TheMainNavigationDrawer,
            TheMainTopToolbar
        }
    }
</script>

<style scoped>

</style>