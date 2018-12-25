<template>
    <v-toolbar
        color="indigo"
        dark
        fixed
        app
    >
        <v-toolbar-side-icon @click.stop="componentStoreMx_mutation(componentStoreMx_STORE.COMPONENTS.MUTATIONS.PROP.TOGGLE,{cid: 'the-main-navigation-drawer', prop: 'visible'})" />
        <v-toolbar-title>Application</v-toolbar-title>
    </v-toolbar>
</template>

<script>
import ComponentsStoreMx from '../../src/mixins/ComponentsStoreMx';

export default {
    name: 'TheMainTopToolbar',
    mixins: [
        ComponentsStoreMx
    ],
    data() {
        return {
            componentStoreMx_cid: 'the-main-top-toolbar'
        };
    },
};
</script>

<style scoped>

</style>