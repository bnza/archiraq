<template>
    <data-card
        id="item-form"
        data-test="vw-site-edit--data-card"
    >
        <vw-site-edit-data-card-toolbar
            slot="toolbar"
            :layer-id="baseTypename"
        />
        <vw-site-edit-data-card-form
            v-if="item"
            slot="data"
            :item.sync="item"
        />
        <template slot="actions">
            <v-spacer />
            <v-btn
                color="blue darken-1"
                flat
                :disabled="isRequestPending"
                data-test="v-btn--close"
                @click.native="$router.back()"
            >
                Close
            </v-btn>
            <v-btn
                flat
                :disabled="isRequestPending"
                color="blue darken-1"
                data-test="v-btn--submit"
                @click.native="submit()"
            >
                Submit
            </v-btn>
        </template>
    </data-card>
</template>

<script>
import {CID_VW_SITE_EDIT_DATA_CARD as CID} from '@/utils/cids';
import DataCard from './DataCard';
import VwSiteEditDataCardToolbar from '@/components/DataCard/VwSiteEditDataCardToolbar';
import VwSiteEditDataCardForm from '@/components/DataCard/VwSiteEditDataCardForm';
import VwSiteItemActionDataCardMx from '@/mixins/DataCard/VwSiteItemActionDataCardMx';

export default {
    name: CID,
    components: {
        DataCard,
        VwSiteEditDataCardToolbar,
        VwSiteEditDataCardForm
    },
    mixins: [
        VwSiteItemActionDataCardMx
    ],
    methods: {
        submit() {
            this.isRequestPending = true;
            let axiosRequestConfig = {
                method: 'put',
                url: `/data/site/${this.itemId}`,
                data: this.item
            };
            this.clientXsrfRequest(axiosRequestConfig).then(() => {
                this.$router.back();
            }).finally(() => {
                this.isRequestPending = false;
            });
        }
    }
};
</script>
