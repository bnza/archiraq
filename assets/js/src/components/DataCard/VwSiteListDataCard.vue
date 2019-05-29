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
            v-if="modalComponentType"
            slot="modal"
            :is-request-pending="isModalRequestPending"
            :visible.sync="isModalVisible"
            @action="executeModalSlotMethod"
        >
            <component
                :is="modalSlotComponent"
                ref="modalSlot"
                :slot="modalComponentType"
                :is-request-pending.sync="isModalRequestPending"
                :modal-props="modalProps"
            />
        </component>
    </data-card>
</template>

<script>
import DataCard from './DataCard';
import VwSiteListDataCardToolbar from './VwSiteListDataCardToolbar';
import VwSiteListDataCardTable from './VwSiteListDataCardTable';
import DataCardDynamicModalMx from '@/mixins/DataCardDynamicModalMx';
import WfsDataCardMx from '@/mixins/WfsDataCardMx';

import {CID_VW_SITE_LIST_DATA_CARD as CID, QUERY_TYPENAME_VW_SITES} from '@/utils/cids';
import {SITE_POLY_WFS_TYPENAME} from '@/components/MapLayerVectorWfsVwSites';


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
        DataCardExportDialog: () => import(
            /* webpackChunkName: "DataCardFilterDialog" */
            './DataCardExportDialog'
        ),
        DataCardFilterDialog: () => import(
            /* webpackChunkName: "DataCardFilterDialog" */
            './DataCardFilterDialog'
        ),
        DataCardExportDialogSlot: () => import(
            /* webpackChunkName: "VwSiteDataCardFilterDialog" */
            './ExportDialog/VwSiteExportDialogContent'
        ),
        DataCardFilterDialogSlot: () => import(
            /* webpackChunkName: "VwSiteDataCardFilterDialog" */
            './FilterDialogEntry/VwSiteConditionRows'
        )
    },
    mixins: [
        DataCardDynamicModalMx,
        WfsDataCardMx
    ],
    data() {
        return {
            cid: CID,
            headers: headers,
        };
    },
    computed: {
        limitTypeName() {
            return SITE_POLY_WFS_TYPENAME;
        },
        modalProps() {
            const modalProps = {
                export: {
                    typename: SITE_POLY_WFS_TYPENAME,
                    queryTypename: QUERY_TYPENAME_VW_SITES
                }
            };
            return modalProps.hasOwnProperty(this.modalComponentType) ? modalProps[this.modalComponentType] : {};
        }
    },
};
</script>
