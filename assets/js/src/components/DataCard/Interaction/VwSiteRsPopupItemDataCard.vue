<template>
    <div class="content">
        <div v-if="isRequestPending">
            <v-progress-circular />
        </div>
        <div v-else>
            <popup-text-field
                    label="Entry ID"
                    :value="properties.entry_id"
            />
            <popup-text-field
                label="District"
                :value="properties.district"
            />
            <popup-text-field
                label="Threats"
                :value="properties.threats"
            />
            <popup-text-field
                label="Verified on field"
                :value="properties.survey_verified_on_field"
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

    name: 'VwSiteRsPopupItemDataCard',
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
