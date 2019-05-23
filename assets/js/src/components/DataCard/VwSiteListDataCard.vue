<template>
    <data-card data-test="vw-site-table--data-card">
        <vw-site-list-data-card-toolbar
            slot="toolbar"
            @openModal="openModal"
        />
        <vw-site-list-data-card-table
            slot="data"
            :items="items"
            :total-items="totalItems"
            :headers="headers"
            :typename="typename"
            :is-request-pending="isRequestPending"
        />
        <component
            :is="modalComponent"
            v-if="modalComponent"
            slot="modal"
            :visible.sync="isModalVisible"
            @submit="$refs.filter.submit()"
            @clear="$refs.filter.clear()"
        >
            <vw-site-condition-rows
                ref="filter"
                slot="filter"
            />
        </component>
    </data-card>
</template>

<script>
import DataCard from './DataCard';
import VwSiteListDataCardToolbar from './VwSiteListDataCardToolbar';
import VwSiteListDataCardTable from './VwSiteListDataCardTable';
import WfsDataCardMx from '@/mixins/WfsDataCardMx';

import {pascalCase} from '@/utils/utils';
import {CID_VW_SITE_LIST_DATA_CARD as CID} from '@/utils/cids';
import {SITE_POINT_WFS_TYPENAME, SITE_POLY_WFS_TYPENAME} from '@/components/MapLayerVectorWfsVwSites';

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
        VwSiteListDataCardTable,
        DataCardFilterDialog: () => import(
            /* webpackChunkName: "DataCardFilterDialog" */
            './DataCardFilterDialog'
        ),
        VwSiteConditionRows: () => import(
            /* webpackChunkName: "VwSiteDataCardFilterDialog" */
            './FilterDialogEntry/VwSiteConditionRows'
        )
    },
    mixins: [
        WfsDataCardMx
    ],
    data() {
        return {
            cid: CID,
            headers: headers,
            modalComponent: '',
            isModalVisible: false
        };
    },
    computed: {
        hitsTypeName() {
            return SITE_POINT_WFS_TYPENAME;
        },
        limitTypeName() {
            return SITE_POLY_WFS_TYPENAME;
        }
    },
    methods: {
        openModal(event) {
            const type = pascalCase(event);
            this.modalComponent = `DataCard${type}Dialog`;
            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
        }
    }
};
</script>
