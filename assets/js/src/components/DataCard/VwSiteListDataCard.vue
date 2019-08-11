<template>
    <data-card data-test="vw-site-table--data-card">
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
                :is-request-pending.sync="isModalRequestPending"
                :modal-props="modalProps"
            />
        </component>
    </data-card>
</template>

<script>
import {snakeCase} from 'lodash';
import DataCard from './DataCard';
import VwSiteListDataCardToolbar from './VwSiteListDataCardToolbar';
import VwSiteListDataCardTable from './VwSiteListDataCardTable';
import DataCardDynamicModalMx from '@/mixins/DataCardDynamicModalMx';
import WfsDataCardMx from '@/mixins/WfsDataCardMx';

import {CID_VW_SITE_LIST_DATA_CARD as CID, HEADERS_VW_SITE_LIST_DATA_CARD_TABLE, QUERY_TYPENAME_VW_SITES_RS, QUERY_TYPENAME_VW_SITES_SURVEY} from '@/utils/cids';


/*export const headers = {
    [QUERY_TYPENAME_VW_SITES_SURVEY]: [
        {
            text: 'id',
            value: 'id'
        },
        {
            text: 'SBAH (no)',
            value: 'sbah_no'
        },
        {
            text: 'cadastre',
            value: 'cadastre'
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
            value: 'survey_refs'
        },
        {
            text: 'threats',
            value: 'threats'
        },
        {
            text: 'features',
            value: 'features'
        },
        {
            text: 'E',
            value: 'e'
        },
        {
            text: 'N',
            value: 'n'
        },
        {
            text: 'length (m)',
            value: 'length'
        },
        {
            text: 'width (m)',
            value: 'width'
        },
        {
            text: 'area (ha)',
            value: 'area'
        },
        {
            text: 'remarks',
            value: 'remarks'
        },
    ],
    [QUERY_TYPENAME_VW_SITES_RS]: [
        {
            text: 'id',
            value: 'id'
        },
        {
            text: 'modern name',
            value: 'modern_name'
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
            text: 'threats',
            value: 'threats'
        },
        {
            text: 'E',
            value: 'e'
        },
        {
            text: 'N',
            value: 'n'
        },
        {
            text: 'length (m)',
            value: 'length'
        },
        {
            text: 'width (m)',
            value: 'width'
        },
        {
            text: 'area (ha)',
            value: 'area'
        },
        {
            text: 'remarks',
            value: 'remarks'
        },
    ]
};*/

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
            headers: HEADERS_VW_SITE_LIST_DATA_CARD_TABLE[this.queryTypename],
        };
    },
    computed: {
        /**
         * Base typename: query name like string (e.g. "base_type_name") used as map layer id
         * @return {string}
         */
        baseTypename() {
            return snakeCase(this.queryTypename);
        },
        typename() {
            return `archiraq:${this.baseTypename}_poly`;
        },
        modalProps() {
            const modalProps = {
                filter: {
                    typename: this.typename,
                    queryTypename: this.queryTypename
                },
                export: {
                    typename: this.typename,
                    queryTypename: this.queryTypename
                }
            };
            return modalProps.hasOwnProperty(this.modalComponentType) ? modalProps[this.modalComponentType] : {};
        }
    },
};
</script>
