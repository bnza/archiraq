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
                offset-xs1
            >
                <h3 data-test="contribute-upload-title">
                    {{ startCase(type) }} {{ startCase(format) }} contribute upload
                </h3>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-switch
                v-model="isContributeBundled"
                label="Contribute data inside zip file"
            />
        </v-layout>
        <contribute-upload-form
            v-if="!isContributeBundled"
            :contribute.sync="contribute"
        />
        <v-layout
            row
            wrap
        >
            <v-flex
                xs10
                offset-xs1
            >
                <upload-btn
                    title="Select file"
                    @file-update="update"
                >
                    <template slot="icon">
                        <v-icon>add</v-icon>
                    </template>
                </upload-btn>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                v-if="isRequestPending"
                xs10
                offset-xs1
            >
                <v-progress-linear v-model="uploadProgress" />
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
                <v-btn
                    color="blue darken-1"
                    :disabled="isRequestPending"
                    flat
                    data-test="v-btn--close"
                    @click.native="$router.back()"
                >
                    Close
                </v-btn>
                <v-btn
                    flat
                    color="blue darken-1"
                    :disabled="!isValid || isRequestPending"
                    data-test="v-btn--submit"
                    @click.native="upload"
                >
                    Submit
                </v-btn>
            </v-flex>
        </v-layout>
    </v-container>
</template>


<script>
import FileSaver from 'file-saver';
import UploadButton from 'vuetify-upload-button';
import ContributeUploadForm from '@/components/ContributeUploadForm';
import HttpClientMx from '@/mixins/HttpClientMx';
import {pascalCase} from '@/utils/utils';
import {startCase} from 'lodash';

export default {
    name: 'ContributeUpload',
    components: {
        'upload-btn': UploadButton,
        ContributeUploadForm
    },
    mixins: [
        HttpClientMx
    ],
    props: {
        type: {
            type: String,
            required: true
        },
        format: {
            type: String,
            required: true
        },
    },
    data() {
        return {
            file: null,
            contributeId: '',
            isContributeBundled: false,
            contribute: {},
            isRequestPending: false,
            uploadProgress: 0
        };
    },
    computed: {
        uploadUrl() {
            let type = pascalCase(this.type);
            let format = pascalCase(this.format);
            return `/job/contribute/import/full${type}${format}/${this.contributeId}`;
        },
        isContributeValid() {
            let isContributeValid = true;
            if (!this.isContributeBundled) {
                isContributeValid = !!Object.keys(this.contribute).length;
            }
            return isContributeValid;
        },
        isValid() {
            return this.isContributeValid & !!this.file;
        }
    },
    mounted() {
        this.getContributeId();
    },
    methods: {
        startCase,
        update (file) {
            this.file = file;
        },
        getContributeId () {
            const vm = this;
            const axiosRequestConfig = {
                method: 'get',
                url: '/job/id/generate'
            };
            return this.clientRequest(axiosRequestConfig).then((response) => {
                vm.contributeId = response.data;
            });
        },
        getContributeDraftErrors () {
            let axiosRequestConfig = {
                method: 'get',
                url: `/job/contribute/${this.contributeId}/${this.type}/draft-errors`,
                responseType: 'blob',
            };
            return this.clientRequest(axiosRequestConfig).then((response) => {
                FileSaver.saveAs(
                    new Blob([response.data]),
                    'validationErrors.csv',
                    {type: `${response.data.type}`}
                );
            });
        },
        upload() {
            const vm = this;
            const formData = new FormData();
            if (!this.isContributeBundled) {
                formData.append('contributeData', JSON.stringify(this.contribute));
            }
            formData.append('contributeFile', this.file);
            this.isRequestPending = true;
            let axiosRequestConfig = {
                method: 'post',
                url: this.uploadUrl,
                data: formData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: function(progressEvent) {
                    vm.uploadProgress = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                    if (vm.uploadProgress === 100) {
                        vm.$router.push(`/contribute/${vm.contributeId}/status`);
                    }
                }
            };

            return this.clientXsrfRequest(axiosRequestConfig)
                .catch(
                    (error) => {
                        if (error.response && error.response.data.errors === 'Draft validation failed') {
                            vm.getContributeDraftErrors();
                        }
                    }
                ).finally(
                    () => {
                        vm.isRequestPending = false;
                    }
                );
        }
    }
};
</script>
