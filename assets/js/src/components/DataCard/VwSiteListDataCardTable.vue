<template>
    <v-data-table
        :rows-per-page-items="[5,10,25]"
        :headers="headers"
        :total-items="totalItems"
        :items="items"
        :pagination.sync="pagination"
    >
        <template
            slot="items"
            slot-scope="props"
        >
            <td
                class="text-xs-right"
            >
                <strong>{{ props.item.id }}</strong>
            </td>
            <td
                class="text-xs-right"
            >
                {{ props.item.sbah_no }}
            </td>
            <td
                class="text-xs-right"
            >
                {{ props.item.modern_name }}
            </td>
            <td
                class="text-xs-right"
            >
                {{ props.item.nearest_city }}
            </td>
            <td
                class="text-xs-right"
            >
                {{ props.item.ancient_name }}
            </td>
            <td
                class="text-xs-right"
            >
                {{ props.item.district }}
            </td>
            <td
                class="text-xs-right"
            >
                {{ props.item.governorate }}
            </td>
            <td
                class="text-xs-right"
            >
                {{ props.item.nation }}
            </td>
            <td
                class="text-xs-right"
            >
                {{ props.item.chronology }}
            </td>
            <td
                class="text-xs-right"
            >
                {{ props.item.surveyRefs }}
            </td>
            <td
                class="text-xs-right"
            >
                {{ props.item.area }}
            </td>
        </template>
    </v-data-table>
</template>

<script>
import DataCardTableMx from '../../mixins/DataCardTableMx';
export default {
    name: 'VwSiteDataCardTable',
    mixins: [
        DataCardTableMx
    ]
};
</script>

<style scoped>

</style>
