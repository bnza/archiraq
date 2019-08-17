<template>
    <v-data-table
        :headers="headers"
        :items="items"
    >
        <template v-slot:items="props">
            <td>{{ props.item.chronology.code }}</td>
            <td class="text-xs-right">
                {{ props.item.chronology.name }}
            </td>
            <td class="text-xs-right">
                {{ yearToCanonicalString(props.item.chronology.date_low) }}
            </td>
            <td class="text-xs-right">
                {{ yearToCanonicalString(props.item.chronology.date_high) }}
            </td>
        </template>
    </v-data-table>
</template>

<script>
import {yearToCanonicalString} from '@/utils/utils';

export default {
    name: 'VwSiteChronologiesReadDataCardTable',
    props: {
        items: {
            type: Array,
            default() {
                return [];
            }
        }
    },
    data() {
        return {
            headers: [
                {
                    text: 'code',
                    value: 'chronology.code'
                },
                {
                    text: 'name',
                    value: 'chronology.name'
                },
                {
                    text: 'date (low)',
                    value: 'chronology.date_low'
                },
                {
                    text: 'date (high)',
                    value: 'chronology.date_high'
                },
            ]
        };
    },
    methods: {
        yearToCanonicalString
    }
};
</script>

<style scoped>

</style>
