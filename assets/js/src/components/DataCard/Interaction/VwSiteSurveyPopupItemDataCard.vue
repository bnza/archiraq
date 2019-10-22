<template>
    <div class="content">
        <div v-if="isRequestPending" >
            <v-progress-circular />
        </div>
        <div v-else>
            <popup-text-field
                label="District"
                :value="properties.district"
            />
            <popup-text-field
                label="Modern name"
                :value="properties.modern_name"
            />
            <popup-text-field
                label="Surveys"
                :value="properties.survey_refs"
            />
            <popup-text-field
                label="Chronology"
                :value="properties.chronology"
            />
            <popup-text-field
                label="Area (ha)"
                :value="properties.area"
            />
        </div>
    </div>
</template>
<script>
import PopupTextField from '@/components/DataCard/Interaction/PopupTextField';
import VwSitePopupItemDataCardMx from '@/mixins/VwSitePopupItemDataCardMx';

export default {
    name: 'VwSiteSurveyPopupItemDataCard',
    components: {
        PopupTextField
    },
    mixins: [
        VwSitePopupItemDataCardMx
    ]
};
</script>

<style scoped>
    .content {
     padding: 10px;
    }
</style>
