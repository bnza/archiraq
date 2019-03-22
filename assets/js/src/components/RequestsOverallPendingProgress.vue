<template>
    <v-progress-circular
        v-if="clientHasPendingRequests"
        indeterminate
        color="primary"
    />
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
