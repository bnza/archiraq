<template>
    <data-card
        id="item-form"
        data-test="vw-site-read--data-card"
    >
        <vw-site-read-data-card-toolbar
            slot="toolbar"
            :layer-id="baseTypename"
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
import VwSiteActionDataCardMx from '@/mixins/DataCard/VwSiteActionDataCardMx';
import HttpClientMx from '@/mixins/HttpClientMx';
export default {
    name: CID,
    components: {
        DataCard,
        VwSiteReadDataCardToolbar,
        VwSiteReadDataCardForm
    },
    mixins: [
        HttpClientMx,
        VwSiteActionDataCardMx
    ],
    data() {
        return {
            item: null
        };
    },
    watch: {
        itemId() {
            this.fetchItem();
        }
    },
    mounted() {
        this.fetchItem();
    },
    methods: {
        fetchItem() {
            let vm = this;
            let axiosRequestConfig = {
                method: 'get',
                url: `/data/site/${this.itemId}`,
            };
            this.clientRequest(axiosRequestConfig).then((response) => {
                vm.item = response.data;
            });
        }
    }
};
</script>

<style scoped>

</style>
