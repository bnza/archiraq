<template>
    <v-navigation-drawer
        v-model="visible"
        clipped
        :hide-overlay="true"
        app
    />
</template>

<script>
import {CID_THE_MAIN_NAVIGATION_DRAWER} from '../utils/constants';
import ComponentsStoreMx from '../../src/mixins/ComponentsStoreMx';

export default {
    name: 'TheMainNavigationDrawer',
    mixins: [
        ComponentsStoreMx
    ],
    data() {
        return {
            componentStoreMx_cid: CID_THE_MAIN_NAVIGATION_DRAWER
        };
    },
    computed: {
        visible: {
            get() {
                return this.componentStoreMx_getStoreProp('visible');
            },
            set(value) {
                this.componentStoreMx_setStoreProp('visible', value);
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
