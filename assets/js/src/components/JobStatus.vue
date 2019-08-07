<template>
    <div>
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
                xs3
                offset-xs1
                offset-lg2
            >
                <p class="text-xs-right">
                    <strong>
                        Description:
                    </strong>
                </p>
            </v-flex>
            <v-flex
                xs7
                lg4
            >
                <p class="text-xs-left">
                    {{ job.description }}
                </p>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
            data-test="statusJobRow"
        >
            <v-flex
                xs3
                offset-xs1
                offset-lg2
            >
                <p class="text-xs-right">
                    <strong>
                        Status:
                    </strong>
                </p>
            </v-flex>
            <v-flex
                xs7
                lg4
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
                offset-lg2
            >
                <p class="text-xs-right">
                    <strong>
                        Message:
                    </strong>
                </p>
            </v-flex>
            <v-flex
                xs7
                lg4
            >
                <p class="text-xs-left">
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
                offset-lg2
            >
                <p class="text-xs-right">
                    <strong>
                        Error:
                    </strong>
                </p>
            </v-flex>
            <v-flex
                xs7
                lg4
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
                offset-lg2
            >
                <p class="text-xs-right">
                    <strong>
                        Tasks:
                    </strong>
                </p>
            </v-flex>
            <v-flex
                xs7
                lg4
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
import {getStatusText, getStatusColor, getStatusIcon, getJobProgressPercentage} from '@/utils/utils';

export default {
    name: 'JobStatus',
    components: {
        TaskProgress
    },
    props: {
        job: {
            type: Object,
            required: true
        }
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
