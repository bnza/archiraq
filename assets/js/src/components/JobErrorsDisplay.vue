<template>
    <div>
        <component
            :is="getComponent(error.key)"
            v-for="(error, index) in errors"
            :key="index"
            :item="error"
            :index="index"
            :error="error"
        />
    </div>
</template>

<script>
import {pascalCase} from '@/utils/utils';

export default {
    name: 'JobErrorsDisplay',
    components: {
        JobErrorEntryMismatchDisplay: () => import(
            /* webpackChunkName: "JobErrorEntryMismatchDisplay" */
            './JobErrorEntryMismatchDisplay'
        ),
        JobErrorDraftValidationDisplay: () => import(
            /* webpackChunkName: "JobErrorDraftValidationDisplay" */
            './JobErrorDraftValidationDisplay'
        )
    },
    props: {
        errors: {
            type: Array,
            required: true
        }
    },
    methods: {
        getComponent(key) {
            if (['entry_mismatch', 'draft_validation'].indexOf(key) === -1) {
                key = 'unhandled';
            }
            const chunks = ['JobError', key, 'Display'];
            return chunks.map(pascalCase).join('');
        }
    }
};
</script>

<style scoped>

</style>
