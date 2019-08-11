<template>
    <v-data-table
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
            />
        </template>
    </v-data-table>
</template>

<script>
import VwSiteListDataCardTableRow from '@/components/DataCard/VwSiteListDataCardTableRow';
import DataCardTableMx from '../../mixins/DataCardTableMx';

export default {
    name: 'VwSiteDataCardTable',
    components: {
        VwSiteListDataCardTableRow
    },
    mixins: [
        DataCardTableMx
    ]
};
</script>

<style scoped>

</style>
