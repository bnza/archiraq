<template>
    <data-card
        id="item-form"
        data-test="vw-site-edit--data-card"
    >
        <vw-site-edit-data-card-toolbar
            slot="toolbar"
            :layer-id="baseTypename"
        />
        <vw-site-edit-data-card-form
            v-if="item"
            slot="data"
            :item.sync="item"
            :interaction-modify-ready="interactionModifyReady"
        />
        <template slot="actions">
            <v-spacer />
            <v-btn
                color="blue darken-1"
                flat
                :disabled="isRequestPending"
                data-test="v-btn--close"
                @click.native="$router.back()"
            >
                Close
            </v-btn>
            <v-btn
                flat
                :disabled="isRequestPending"
                color="blue darken-1"
                data-test="v-btn--submit"
                @click.native="submit()"
            >
                Submit
            </v-btn>
        </template>
    </data-card>
</template>

<script>
import SnackbarComponentStoreMx from '@/mixins/SnackbarComponentStoreMx';
import MapContainerComponentStoreMx from '@/mixins/MapContainerComponentStoreMx';
import {CID_VW_SITE_EDIT_DATA_CARD as CID} from '@/utils/cids';
import DataCard from './DataCard';
import VwSiteEditDataCardToolbar from '@/components/DataCard/VwSiteEditDataCardToolbar';
import VwSiteEditDataCardForm from '@/components/DataCard/VwSiteEditDataCardForm';
import VwSiteItemActionDataCardMx from '@/mixins/DataCard/VwSiteItemActionDataCardMx';

export default {
    name: CID,
    components: {
        DataCard,
        VwSiteEditDataCardToolbar,
        VwSiteEditDataCardForm
    },
    mixins: [
        SnackbarComponentStoreMx,
        MapContainerComponentStoreMx,
        VwSiteItemActionDataCardMx
    ],
    data() {
        return {
            cid: CID,
        };
    },
    computed: {
        interactionModifyReady: {
            get() {
                return this.getProp('interactionModifyReady');
            },
            set(value) {
                this.setProp('interactionModifyReady', value);
            }
        }
    },
    created() {
        this.interactionModifyReady = false;
    },
    methods: {
        fetchCallback() {
            this.mapContainerCallMethod('zoomToItemGeometry', JSON.parse(this.item.geom.geom));
        },
        refreshMapLayerSource() {
            this.componentsSetComponentProp({
                cid: this.wfsComponentCid,
                prop: 'refresh',
                value: true
            });
        },
        submit() {
            this.isRequestPending = true;
            let axiosRequestConfig = {
                method: 'put',
                url: `/data/site/${this.itemId}`,
                data: this.item
            };
            this.clientXsrfRequest(axiosRequestConfig).then(() => {
                this.refreshMapLayerSource();
                this.$router.back();
            }).catch((error) => {
                this.displaySnackbar(error.errorMessages, 'error');
                this.$router.push('/login');
            }).finally(() => {
                this.isRequestPending = false;
            });
        }
    }
};
</script>
