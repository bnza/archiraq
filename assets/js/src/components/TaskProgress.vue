<template>
    <div>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs1
            >
                <p class="text-xs-right">
                    #<strong>{{ task.num }}:</strong>
                </p>
            </v-flex>
            <v-flex
                xs11
            >
                <p class="text-xs-left">
                    {{ task.description }}
                </p>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs9
                offset-xs1
            >
                <v-progress-linear v-model="progress" />
            </v-flex>
            <v-flex
                xs2
            >
                {{ task.currentStepNum }}/{{ task.stepsNum }}
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
import {getProgressPercentage} from '@/utils/utils';

export default {
    name: 'TaskProgress',
    props: {
        task: {
            type: Object,
            required: true
        }
    },
    computed: {
        progress() {
            return getProgressPercentage(this.task);
        }
    }
};
</script>
