<template>
    <data-card>
        <vw-site-list-data-card-toolbar slot="toolbar" />
        <vw-site-list-data-card-table
            slot="data"
            :items="items"
            :total-items="totalItems"
            :headers="headers"
            :typename="typename"
            :is-request-pending="isRequestPending"
        />
    </data-card>
</template>

<script>
import DataCard from './DataCard';
import VwSiteListDataCardToolbar from './VwSiteListDataCardToolbar';
import VwSiteListDataCardTable from './VwSiteListDataCardTable';
import DataCardMx from '../../mixins/DataCardMx';

import {CID_VW_SITE_LIST_DATA_CARD as CID} from '../../utils/cids';

const headers = [
    {
        text: 'id',
        value: 'id'
    },
    {
        text: 'SBAH (no)',
        value: 'sbah_no'
    },
    {
        text: 'modern name',
        value: 'modern_name'
    },
    {
        text: 'nearest city',
        value: 'nearest_city'
    },
    {
        text: 'ancient name',
        value: 'ancient_name'
    },
    {
        text: 'district',
        value: 'district'
    },
    {
        text: 'governorate',
        value: 'governorate'
    },
    {
        text: 'nation',
        value: 'nation'
    },
    {
        text: 'chronology',
        value: 'chronology'
    },
    {
        text: 'surveys',
        value: 'surveyRefs'
    },
    {
        text: 'area',
        value: 'area'
    },

];

export default {
    name: CID,
    components: {
        DataCard,
        VwSiteListDataCardToolbar,
        VwSiteListDataCardTable
    },
    mixins: [
        DataCardMx
    ],
    data() {
        return {
            cid: CID,
            headers: headers
        };
    }
};
</script>

<style scoped>

</style>
