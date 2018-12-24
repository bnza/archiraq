<template>
    <v-toolbar
            flat
            dense
    >
        <v-toolbar-side-icon
                @click.stop="$_ComponentStoreMx_mutation($_ComponentStoreMx_STORE.COMPONENTS.MUTATIONS.PROP.TOGGLE,{cid: 'the-map-layers-drawer', prop: 'visible'})"/>
        <v-toolbar-title>Title</v-toolbar-title>
    </v-toolbar>
</template>

<script>
    import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx'
    export default {
        name: "TheMapToolbar",
        mixins: [
            MapContainerComponentStoreMx
        ],
    }
</script>

<style scoped>

</style>