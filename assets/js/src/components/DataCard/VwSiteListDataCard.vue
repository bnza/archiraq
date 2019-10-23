<template>
    <data-card
        id="data-table"
        data-test="vw-site-table--data-card"
    >
        <vw-site-list-data-card-toolbar
            slot="toolbar"
            :layer-id="baseTypename"
            @openModal="openModal"
        />
        <vw-site-list-data-card-table
            slot="data"
            :items="items"
            :total-items="totalItems"
            :headers="headers"
            :query-typename="queryTypename"
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
                :is-modal-request-pending.sync="isModalRequestPending"
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
import VwSiteActionDataCardMx from '@/mixins/DataCard/VwSiteActionDataCardMx';
import WfsDataCardMx from '@/mixins/WfsDataCardMx';

import {CID_VW_SITE_LIST_DATA_CARD as CID, HEADERS_VW_SITE_LIST_DATA_CARD_TABLE} from '@/utils/cids';

export default {
    name: CID,
    components: {
        DataCard,
        VwSiteListDataCardToolbar,
        VwSiteListDataCardTable,
        DataCardExportDialog: () => import(
            /* webpackChunkName: "DataCardExportDialog" */
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
        VwSiteActionDataCardMx,
        DataCardDynamicModalMx,
        WfsDataCardMx
    ],
    computed: {
        headers() {
            return  HEADERS_VW_SITE_LIST_DATA_CARD_TABLE[this.queryTypename];
        },
        modalProps() {
            const modalProps = {
                filter: {
                    typename: this.typename,
                    queryTypename: this.queryTypename,
                },
                export: {
                    typename: this.typename,
                    queryTypename: this.queryTypename,
                }
            };
            return modalProps.hasOwnProperty(this.modalComponentType) ? modalProps[this.modalComponentType] : {};
        }
    },
};
</script>
