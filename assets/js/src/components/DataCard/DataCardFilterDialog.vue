<template>
    <v-dialog
        v-model="visibleC"
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
                    @click="$emit('clear')"
                >
                    Clear
                </v-btn>
                <v-btn
                    data-test="submit"
                    flat
                    color="primary"
                    @click="$emit('submit')"
                >
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'VwSiteDataCardFilterDialog',
    props: {
        visible: {
            type: Boolean,
            required: true
        }
    },
    computed: {
        visibleC: {
            get() {
                return this.visible;
            },
            set(value) {
                this.$emit('update:visible', value);
            }
        }
    }
};
</script>

<style scoped>

</style>
