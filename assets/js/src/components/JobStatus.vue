<template>
    <div>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs10
                offset-xs1
            >
                <v-progress-circular
                    :rotate="360"
                    :size="100"
                    :width="15"
                    :value="overallProgress"
                    :color="statusColor"
                >
                    {{ overallProgress }}
                </v-progress-circular>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs10
                offset-xs1
            >
                <v-dialog
                    v-model="cancelDialog"
                    max-width="290"
                >
                    <template v-slot:activator="{ on }">
                        <v-btn
                            v-if="job.status.isRunning"
                            flat
                            color="red darken-1"
                            v-on="on"
                        >
                            Cancel job
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title class="headline">
                            Cancel job?
                        </v-card-title>
                        <v-card-text>Are you sure you want to cancel this job?</v-card-text>
                        <v-card-actions>
                            <v-spacer />
                            <v-btn
                                color="green darken-1"
                                flat
                                @click="cancelDialog = false"
                            >
                                No
                            </v-btn>
                            <v-btn
                                color="red darken-1"
                                flat
                                @click="$emit('cancelJob'); cancelDialog = false"
                            >
                                Cancel job
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs3
                offset-xs1
            >
                <p class="text-xs-right">
                    <strong>
                        Description:
                    </strong>
                </p>
            </v-flex>
            <v-flex
                xs7
            >
                <p class="text-xs-left">
                    {{ job.description }}
                </p>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs3
                offset-xs1
            >
                <p class="text-xs-right">
                    <strong>
                        Status:
                    </strong>
                </p>
            </v-flex>
            <v-flex
                xs7
            >
                <p class="text-xs-left">
                    <v-icon
                        :color="statusColor"
                        small
                    >
                        {{ statusIcon }}
                    </v-icon>
                    {{ statusText }}
                </p>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs3
                offset-xs1
            >
                <p class="text-xs-right">
                    <strong>
                        Message:
                    </strong>
                </p>
            </v-flex>
            <v-flex
                xs7
            >
                <job-errors-display
                    v-if="job.status.isError"
                    :errors="JSON.parse(job.message)"
                />
                <p
                    v-else
                    class="text-xs-left"
                >
                    {{ job.message }}
                </p>
            </v-flex>
        </v-layout>
        <v-layout
            v-show="job.error"
            row
            wrap
        >
            <v-flex
                xs3
                offset-xs1
            >
                <p class="text-xs-right">
                    <strong>
                        Error:
                    </strong>
                </p>
            </v-flex>
            <v-flex
                xs7
            >
                <p class="text-xs-left">
                    {{ job.error }}
                </p>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs3
                offset-xs1
            >
                <p class="text-xs-right">
                    <strong>
                        Tasks:
                    </strong>
                </p>
            </v-flex>
            <v-flex
                xs7
            >
                <task-progress
                    v-for="task in job.tasks"
                    :key="task.num"
                    :task="task"
                />
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
import TaskProgress from '@/components/TaskProgress';
import JobErrorsDisplay from '@/components/JobErrorsDisplay';
import {getStatusText, getStatusColor, getStatusIcon, getJobProgressPercentage} from '@/utils/utils';

export default {
    name: 'JobStatus',
    components: {
        TaskProgress,
        JobErrorsDisplay
    },
    props: {
        job: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            cancelDialog: false
        };
    },
    computed: {
        statusText() {
            return getStatusText(this.job.status);
        },
        statusColor() {
            return getStatusColor(this.job.status);
        },
        statusIcon() {
            return getStatusIcon(this.job.status);
        },
        overallProgress() {
            return getJobProgressPercentage(this.job);
        }
    },
};
</script>

<style scoped>

</style>
