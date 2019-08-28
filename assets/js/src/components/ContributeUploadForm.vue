<template>
    <validation-observer ref="obs">
        <v-layout
            row
            wrap
        >
            <v-flex
                xs6
                wrap
            >
                <validation-provider
                    v-slot="{errors, valid}"
                    name="Contributor"
                    rules="required"
                >
                    <v-text-field
                        v-model="model.contributor"
                        label="Contributor"
                        :error-messages="errors"
                        :success="valid"
                        required
                    />
                </validation-provider>
            </v-flex>
            <v-flex
                xs6
                wrap
            >
                <validation-provider
                    v-slot="{errors, valid}"
                    name="Email"
                    rules="required|email"
                >
                    <v-text-field
                        v-model="model.email"
                        label="e-mail"
                        :error-messages="errors"
                        :success="valid"
                        required
                    />
                </validation-provider>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs12
                wrap
            >
                <v-text-field
                    v-model="model.institution"
                    label="Institution"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs12
                wrap
            >
                <v-text-field
                    v-model="model.description"
                    label="Description"
                />
            </v-flex>
        </v-layout>
    </validation-observer>
</template>

<script>
import {
    ValidationObserver,
    ValidationProvider,
    extend
} from 'vee-validate';

import { required, email } from 'vee-validate/dist/rules';

// Add the required rule
extend('required', required);
extend('email', email);

export default {
    name: 'ContributeUploadForm',
    components: {
        ValidationProvider,
        ValidationObserver
    },
    props: {
        contribute: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            model: {
                contributor: '',
                email: '',
                institution: '',
                description: ''
            }
        };
    },
    watch: {
        model: {
            handler: async function(value) {
                const valid = await this.$refs.obs.validate();
                if (valid) {
                    this.$emit('update:contribute', value);
                }
            },
            deep: true
        }
    }
};
</script>

<style scoped>

</style>
