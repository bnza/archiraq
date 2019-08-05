<template>
    <v-container
        grid-list-xl
        text-xs-center
    >
        <v-layout
            row
            wrap
        >
            <v-flex
                xs10
                lg8
                offset-xs1
                offset-lg2
            >
                <h3>Job <span class="indigo--text text--darken-2">{{ id }}</span> status</h3>
            </v-flex>
        </v-layout>
        <job-status-refresher :id="id" />
    </v-container>
</template>

<script>
import JobStatusRefresher from '@/components/JobStatusRefresher';
export default {
    name: 'ContributeUploadStatus',
    components: {
        JobStatusRefresher
    },
    props: {
        id: {
            type: String,
            required: true
        }
    }
};
</script>

<style scoped>

</style>
