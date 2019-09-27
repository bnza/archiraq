<template>
    <data-card
        id="item-form"
        data-test="vw-site-read--data-card"
    >
        <vw-site-read-data-card-toolbar
            slot="toolbar"
            :layer-id="baseTypename"
            @edit="navigateToEditForm"
        />
        <vw-site-read-data-card-form
            v-if="item"
            slot="data"
            :item="item"
        />
    </data-card>
</template>

<script>
import {CID_VW_SITE_READ_DATA_CARD as CID} from '@/utils/cids';
import DataCard from './DataCard';
import VwSiteReadDataCardToolbar from './VwSiteReadDataCardToolbar';
import VwSiteReadDataCardForm from './VwSiteReadDataCardForm';
import VwSiteItemActionDataCardMx from '@/mixins/DataCard/VwSiteItemActionDataCardMx';
import {getMapDataItemEditFullPath} from '@/utils/spaRouteQuery';

export default {
    name: CID,
    components: {
        DataCard,
        VwSiteReadDataCardToolbar,
        VwSiteReadDataCardForm
    },
    mixins: [
        VwSiteItemActionDataCardMx
    ],
    methods: {
        navigateToEditForm() {
            const path = getMapDataItemEditFullPath(this.queryTypename, this.itemId);
            this.$router.push(path);
        }
    }
};
</script>

<style scoped>

</style>
