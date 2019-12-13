<template>
    <v-dialog
        v-model="isDialogActive"
        fullscreen
        scrollable
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
                    @click="clear()"
                >
                    Clear
                </v-btn>
                <v-btn
                    data-test="submit"
                    flat
                    color="primary"
                    @click="submit()"
                >
                    Submit
                </v-btn>
                <v-spacer />
                <v-btn
                    data-test="close"
                    flat
                    color="primary"
                    @click="close()"
                >
                    Close
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
    ],
    methods: {
        clear() {
            this.$emit('action', {method: 'clear'});
        },
        close() {
            this.isDialogActive = false;
        },
        submit() {
            this.$emit('action', {method: 'submit'});
            this.close();
        }
    }
};
</script>

<style scoped>
/*    >>> .v-dialog {
        overflow-y: inherit;
    }*/
</style>
