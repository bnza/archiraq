<template>
    <v-data-table
        class="fixed-header"
        :rows-per-page-items="[5,10,25]"
        :headers="headers"
        :total-items="totalItems"
        :items="items"
        :loading="isRequestPending"
        :pagination.sync="pagination"
    >
        <template
            slot="items"
            slot-scope="props"
        >
            <vw-site-list-data-card-table-row
                :headers="headers"
                :item="props.item"
                @navigateToItemForm="navigateToItemForm(props.item.id)"
            />
        </template>
    </v-data-table>
</template>

<script>

import VwSiteListDataCardTableRow from '@/components/DataCard/VwSiteListDataCardTableRow';
import DataCardTableMx from '../../mixins/DataCardTableMx';
import {getMapDataItemReadFullPath} from '@/utils/spaRouteQuery';

export default {
    name: 'VwSiteDataCardTable',
    components: {
        VwSiteListDataCardTableRow
    },
    mixins: [
        DataCardTableMx
    ],
    methods: {
        navigateToItemForm(itemId) {
            this.$router.push(getMapDataItemReadFullPath(this.queryTypename, itemId));
        }
    }
};
</script>

<style scoped>
    /*@see https://www.npmjs.com/package/vuetify-stylus-fixed-table-header*/
    >>> .v-table__overflow {
        overflow-y: auto !important;
        max-height: 65vh !important;
    }
    >>> .theme--light th {
        background-color: #fff;
    }
    >>> .theme--dark th {
        background-color: #424242;
    }
    >>> th {
        position: sticky;
        top: 0;
        z-index: 1;
    }
    >>> tr.v-datatable__progress th {
        top: 55px;
        height: 1px;
    }
</style>
