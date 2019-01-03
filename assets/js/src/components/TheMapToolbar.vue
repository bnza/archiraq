<template>
    <v-toolbar
        flat
        dense
    >
        <v-toolbar-side-icon
            data-cy="the-map-toolbar-left-side-icon"
            @click.stop="componentStoreMx_mutation(componentStoreMx_STORE.MODULES.COMPONENTS.MUTATIONS.PROP.TOGGLE,{cid: 'the-map-layers-drawer', prop: 'visible'})"
        />
        <v-toolbar-title>Title</v-toolbar-title>
    </v-toolbar>
</template>

<script>
import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';
export default {
    name: 'TheMapToolbar',
    mixins: [
        MapContainerComponentStoreMx
    ],
};
</script>

<style scoped>

</style>
