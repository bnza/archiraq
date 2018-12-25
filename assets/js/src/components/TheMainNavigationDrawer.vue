<template>
    <v-navigation-drawer
        v-model="visible"
        clipped
        :hide-overlay="true"
        app
    />
</template>

<script>
import ComponentsStoreMx from '../../src/mixins/ComponentsStoreMx';

export default {
    name: 'TheMainNavigationDrawer',
    mixins: [
        ComponentsStoreMx
    ],
    data() {
        return {
            $_ComponentStoreMx_cid: 'the-main-navigation-drawer'
        };
    },
    computed: {
        visible: {
            get() {
                return this.$_ComponentStoreMx_getStoreProp('visible');
            },
            set(value) {
                this.$_ComponentStoreMx_setStoreProp('visible', value);
            }
        }
    },
    created() {
        this.visible = false;
    },
};
</script>

<style scoped>

</style>