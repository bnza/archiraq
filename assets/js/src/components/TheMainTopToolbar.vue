<template>
    <v-toolbar color="indigo"
               dark
               fixed
               app
    >
        <v-toolbar-side-icon @click.stop="$_ComponentStoreMx_mutation($_ComponentStoreMx_STORE.COMPONENTS.MUTATIONS.PROP.TOGGLE,{cid: 'the-main-navigation-drawer', prop: 'visible'})"></v-toolbar-side-icon>
        <v-toolbar-title>Application</v-toolbar-title>
    </v-toolbar>
</template>

<script>
    import ComponentsStoreMx from '../../src/mixins/ComponentsStoreMx'

    export default {
        name: "TheMainTopToolbar",
        data() {
            return {
                $_ComponentStoreMx_cid: 'the-main-top-toolbar'
            }
        },
        mixins: [
            ComponentsStoreMx
        ],
    }
</script>

<style scoped>

</style>