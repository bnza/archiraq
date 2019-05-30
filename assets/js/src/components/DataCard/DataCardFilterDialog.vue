<template>
    <v-dialog
        v-model="isDialogActive"
    >
        <v-toolbar>
            <v-toolbar-title flat>
                Filter features
            </v-toolbar-title>
        </v-toolbar>
        <v-card>
            <v-card-text>
                <v-container
                    fluid
                    grid-list-xl
                >
                    <slot name="filter" />
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    data-test="clear"
                    flat
                    color="primary"
                    @click="$emit('action', {method: 'clear'})"
                >
                    Clear
                </v-btn>
                <v-btn
                    data-test="submit"
                    flat
                    color="primary"
                    @click="$emit('action', {method: 'submit'})"
                >
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import DataCardDialogMx from '@/mixins/DataCardDialogMx';
export default {
    name: 'DataCardFilterDialog',
    mixins: [
        DataCardDialogMx
    ]
};
</script>

<style scoped>
    >>> .v-dialog {
        overflow-y: inherit;
    }
</style>
