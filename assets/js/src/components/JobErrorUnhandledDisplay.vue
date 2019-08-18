<template>
    <div>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs3
            >
                <h4 class="text-sm-right red--text text--darken-1">
                    Error:
                </h4>
            </v-flex>
            <v-flex
                xs9
            >
                <p class="text-sm-right red--text text--darken-1">
                    {{ error.value }}
                </p>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
import JobErrorDisplayMx from '@/mixins/JobErrorDisplayMx';

export default {
    name: 'JobErrorUnhandledDisplay',
    mixins: [
        JobErrorDisplayMx
    ]
};
</script>

<style scoped>

</style>
