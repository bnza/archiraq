import DataCardMx from '@/mixins/DataCardMx';
import WfsGetFeatureMx from '@/mixins/WfsGetFeatureMx';
import {mapWfsFeatureToTableItem} from '@/utils/wfs';

export default {
    mixins: [
        DataCardMx,
        WfsGetFeatureMx
    ],
    methods: {
        //@TODO check exceptions
        fetch: async function () {
            let wfsRequestConfig = {
                typename: this.typename,
                filter: this.filter,
                pagination: this.pagination
            };

            this.performWfsGetFeatureRequest(wfsRequestConfig).then(
                (response) => {
                    this.items = response.data.features.map(mapWfsFeatureToTableItem);
                    this.totalItems = response.data.numberMatched;
                }
            );
        },
    },
};
