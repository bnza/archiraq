<template>
    <div class="content">
        <popup-text-field
            label="District"
            :value="properties.district"
        />
        <popup-text-field
            label="Chronology"
            :value="properties.chronology"
        />
        <popup-text-field
            label="Surveys"
            :value="properties.survey_refs"
        />
    </div>
</template>
<script>
import PopupTextField from '@/components/DataCard/Interaction/PopupTextField';
export default {

    name: 'VwSitePopupItemDataCard',
    components: {
        PopupTextField
    },
    props: {
        feature: {
            type: Object,
            required: true
        }
    },
    computed: {
        properties() {
            return this.feature.properties || {};
        }
    }
};
</script>

<style scoped>
    .content {
     padding: 10px;
    }
</style>
