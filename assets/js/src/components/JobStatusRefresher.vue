<template>
    <job-status
        v-if="job"
        :job="job"
        @cancelJob="cancelJob"
    />
</template>

<script>
import HttpClientMx from '@/mixins/HttpClientMx';
import JobStatus from '@/components/JobStatus';
export default {
    name: 'JobStatusRefresher',
    components: {JobStatus},
    mixins: [
        HttpClientMx
    ],
    props: {
        id: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            job: null
        };
    },
    watch: {
        job: function (job) {
            if (job.status.isRunning) {
                setTimeout(this.refreshJob, 500);
            }
        },
        id: function() {
            this.refreshJob();
        }
    },
    mounted() {
        this.refreshJob();
    },
    methods: {
        refreshJob() {
            const axiosRequestConfig = {
                method: 'get',
                url: `/job/${this.id}/status`
            };
            return this.clientRequest(axiosRequestConfig).then((response) => {
                this.job = response.data;
            });
        },
        cancelJob() {
            const axiosRequestConfig = {
                method: 'put',
                url: `/job/${this.id}/cancel`
            };
            return this.clientXsrfRequest(axiosRequestConfig).then(() => {
                this.refreshJob();
            });
        },
    }
};
</script>

<style scoped>

</style>
