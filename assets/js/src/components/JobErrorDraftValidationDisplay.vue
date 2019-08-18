<template>
    <div>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs12
            >
                <h4 class="text-sm-left red--text text--darken-1">
                    Draft validation errors
                </h4>
            </v-flex>
        </v-layout>
        <v-data-table
            :headers="headers"
            :items="error.value"
            class="elevation-1"
            :pagination="{rowsPerPage: -1}"
        >
            <template v-slot:items="props">
                <td>{{ props.item.entryId }}</td>
                <td class="text-xs-right">
                    {{ objJoin(props.item.errors, 'path', ', ') }}
                </td>
                <td class="text-xs-right">
                    {{ objJoin(props.item.errors, 'value', ', ') }}
                </td>
                <td class="text-xs-right">
                    {{ objJoin(props.item.errors, 'message', ', ') }}
                </td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import JobErrorDisplayMx from '@/mixins/JobErrorDisplayMx';

export default {
    name: 'JobErrorDraftValidationDisplay',
    mixins: [
        JobErrorDisplayMx
    ],
    data() {
        return {
            headers: [
                {
                    text: 'Entry ID',
                    value: 'entryId'
                },
                {
                    text: 'field error',
                    value: 'errors.path'
                },
                {
                    text: 'field value',
                    value: 'errors.value'
                },
                {
                    text: 'message',
                    value: 'errors.message'
                }
            ]
        };
    },
    methods: {
        objToArray(arr, key) {
            return arr.map((el) => {
                return el[key];
            });
        },
        objJoin(arr, key, glue) {
            return this.objToArray(arr, key).join(glue);
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
