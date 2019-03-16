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

export const CID = 'TheMainNavigationDrawer';

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
