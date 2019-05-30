<template>
    <v-layout
        ref="content"
        row
        wrap
        data-test="vw-site-table--export-content"
    >
        <v-radio-group
            v-model="format"
            :disabled="isRequestPending"
        >
            <v-radio
                label="geoJson"
                value="json"
            />
            <v-radio
                label="GML-3"
                value="gml3"
            />
            <v-radio
                label="KML"
                value="kml"
            />
            <v-radio
                label="Shapefile"
                value="shp"
            />
            <v-radio
                label="CSV"
                value="csv"
            />
        </v-radio-group>
    </v-layout>
</template>

<script>
import FileSaver from 'file-saver';
import HttpClientMx from '@/mixins/HttpClientMx';
import QueryMx from '@/mixins/QueryMx';
import {getFeatureQueryString, setWfsGetFeatureRequestHeaders} from '@/utils/wfs';
import {GET_GUEST_AUTH} from '@/store/geoserver/auth/getters';

const formats = {
    kml: {
        format: 'KML',
        extension: 'kml'
    },
    json: {
        format: 'application/json',
        extension: 'json'
    },
    gml3: {
        format: 'GML3',
        extension: 'gml'
    },
    shp: {
        format: 'shape-zip',
        extension: 'zip'
    },
    csv: {
        format: 'CSV',
        extension: 'csv'
    }
};

const getOutputFormat = (key) => {
    return formats[key].format;
};

const getFormatExtension = (key) => {
    return formats[key].extension;
};

export default {
    name: 'VwSiteExportDialogContent',
    mixins: [
        HttpClientMx,
        QueryMx
    ],
    props: {
        modalProps: {
            type: Object,
            required: true,
            validator: function (value) {
                return value.hasOwnProperty('typename') && value.hasOwnProperty('queryTypename');
            }
        },
        isRequestPending: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            format: 'json'
        };
    },
    computed: {
        outputFormat() {
            return getOutputFormat(this.format);
        },
        downloadFileExtension() {
            return getFormatExtension(this.format);
        },
        typename() {
            return this.modalProps.typename;
        },
        queryTypename() {
            return this.modalProps.queryTypename;
        }
    },
    methods: {
        getUrl() {
            return this.$store.state.geoserver.baseUrl + 'wfs?' +
                getFeatureQueryString({
                    typename: this.typename,
                    filter: this.getQueryFilter(this.queryTypename),
                    format: this.outputFormat,
                    contentDisposition: 'attachment'
                });
        },
        export: async function() {
            let axiosRequestConfig = {
                method: 'get',
                url: this.getUrl(),
                responseType: 'blob',
                headers: setWfsGetFeatureRequestHeaders({}, this.$store.getters[`geoserver/auth/${GET_GUEST_AUTH}`])
            };
            try {
                this.$emit('update:isRequestPending', true);
                const response = await this.clientRequest(axiosRequestConfig);
                FileSaver.saveAs(
                    new Blob([response.data]),
                    `archiraq_export.${this.downloadFileExtension}`,
                    {type: `${response.data.type}`}
                );
            } finally {
                this.$emit('update:isRequestPending', false);
            }
        }
    }
};
</script>
