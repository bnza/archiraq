<template>
    <job-status
        v-if="job"
        :job="job"
    />
</template>

<script>
import {REQUEST} from '@/store/client/actions';
import JobStatus from '@/components/JobStatus';
export default {
    name: 'JobStatusRefresher',
    components: {JobStatus},
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
            return this.$store.dispatch(
                `client/${REQUEST}`,
                {
                    method: 'get',
                    url: `/job/${this.id}/status`
                }
            ).then((response) => {
                this.job = response.data;
            });
        }
    }
};
</script>

<style scoped>

</style>
