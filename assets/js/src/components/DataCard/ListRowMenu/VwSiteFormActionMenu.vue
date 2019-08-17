<template>
    <list-row-actions-menu
        tooltip-text="Menu"
    >
        <v-list data-test="vw-site-table--action-menu">
            <v-list-tile
                @click="$router.back()"
            >
                <v-list-tile-action>
                    <v-icon>
                        arrow_back
                    </v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Back</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
    </list-row-actions-menu>
</template>

<script>
import ListRowActionsMenu from './ListRowActionsMenu';
import AuthMx from '@/mixins/AuthMx';

export default {
    name: 'VwSiteFormActionMenu',
    components: {
        ListRowActionsMenu
    },
    mixins: [
        AuthMx
    ],
};
</script>

<style scoped>

</style>
