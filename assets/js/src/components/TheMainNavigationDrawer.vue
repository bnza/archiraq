<template>
    <v-navigation-drawer
        v-model="visible"
        data-test="the-main-navigation-drawer--aside"
        clipped
        app
    />
</template>

<script>
import ComponentStoreVisibleMx from '../mixins/ComponentStoreVisibleMx';
import {CID_THE_MAIN_NAVIGATION_DRAWER as CID} from '../utils/cids';

export default {
    name: CID,
    mixins: [
        ComponentStoreVisibleMx
    ],
    data() {
        return {
            cid: CID
        };
    }
};
</script>
