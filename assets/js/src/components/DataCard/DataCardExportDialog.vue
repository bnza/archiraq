<template>
    <v-dialog
        v-model="isDialogActive"
    >
        <v-toolbar>
            <v-toolbar-title flat>
                Export features
            </v-toolbar-title>
        </v-toolbar>
        <v-card>
            <v-card-text>
                <v-container
                    fluid
                    grid-list-xl
                >
                    <slot name="export" />
                    <v-progress-linear
                        v-if="isRequestPending"
                        :indeterminate="true"
                    />
                    <div
                        v-else
                        style="margin: 16px 0; height: 7px"
                    />
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    :disabled="isRequestPending"
                    data-test="close"
                    flat
                    color="primary"
                    @click="isDialogActive = false"
                >
                    Close
                </v-btn>
                <v-btn
                    :disabled="isRequestPending"
                    data-test="export"
                    flat
                    color="primary"
                    @click="$emit('action', {method: 'export'})"
                >
                    Export
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import DataCardDialogMx from '@/mixins/DataCardDialogMx';
export default {
    name: 'DataCardExportDialog',
    mixins: [
        DataCardDialogMx
    ],
};
</script>

<style scoped>

</style>
