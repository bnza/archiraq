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
                <h3>{{ startCase(type) }} {{ startCase(format) }} contribute upload</h3>
            </v-flex>
        </v-layout><v-layout
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
                    :disabled="!file || isRequestPending"
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
import {REQUEST, XSRF_REQUEST} from '@/store/client/actions';
import {upperFirst, camelCase, startCase} from 'lodash';

export default {
    name: 'ContributeUpload',
    components: {
        'upload-btn': UploadButton
    },
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
            isRequestPending: false,
            uploadProgress: 0
        };
    },
    computed: {
        uploadUrl() {
            let type = upperFirst(camelCase(this.type));
            let format = upperFirst(camelCase(this.format));
            return `/job/contribute/import/full${type}${format}/${this.contributeId}`;
        },
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
            return this.$store.dispatch(
                `client/${REQUEST}`,
                {
                    method: 'get',
                    url: '/job/id/generate'
                }
            ).then((response) => {
                vm.contributeId = response.data;
            });
        },
        getContributeDraftErrors () {
            const vm = this;
            let axiosRequestConfig = {
                method: 'get',
                url: `/job/contribute/${this.contributeId}/${this.type}/draft-errors`,
                responseType: 'blob',
            };
            return this.$store.dispatch(
                `client/${REQUEST}`,
                axiosRequestConfig
            ).then((response) => {
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
            formData.append('contribute', this.file);
            this.isRequestPending = true;
            this.$store.dispatch(
                `client/${XSRF_REQUEST}`,
                {
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
                }
            ).catch(
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
