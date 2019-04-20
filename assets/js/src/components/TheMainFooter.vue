<template>
    <v-footer
        color="gray"
        app
    >
        <v-layout
            row
            align-center
            justify-space-between
            fill-height
        >
            <v-flex xs1>
                &copy; 2019
            </v-flex>
            <slot /> <!-- router-view -->
            <requests-overall-pending-progress />
        </v-layout>
    </v-footer>
</template>

<script>
import RequestsOverallPendingProgress from './RequestsOverallPendingProgress';
export default {
    name: 'TheMainFooter',
    components: {
        RequestsOverallPendingProgress
    }
};
</script>
