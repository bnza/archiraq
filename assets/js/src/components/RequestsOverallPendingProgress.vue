<template>
    <div style="min-width: 32px">
        <v-progress-circular
            v-if="clientHasPendingRequests"
            indeterminate
            color="primary"
        />
    </div>
</template>

<script>
import HttpClientMx from '../mixins/HttpClientMx';
export default {
    name: 'RequestsOverallPendingProgress',
    mixins: [
        HttpClientMx
    ],
};
</script>

<style scoped>

</style>
