<template>
    <data-card
        color="grey lighten-3"
        :height="32"
    >
        <v-toolbar-title
            slot="toolbar"
        >
            Site
        </v-toolbar-title>
        <vw-site-popup-item-data-card
            slot="data"
            :feature="feature"
        />
    </data-card>
</template>

<script>
import DataCard from '@/components/DataCard/DataCard';
import VwSitePopupItemDataCard from '@/components/DataCard/Interaction/VwSitePopupItemDataCard';
export default {
    name: 'VwSitePopupDataCard',
    components: {
        DataCard,
        VwSitePopupItemDataCard
    },
    props: {
        feature: {
            type: Object,
            required: true
        }
    }
};
</script>

<style scoped>
    .v-toolbar__title {
        font-size: 1rem;
    }
</style>
