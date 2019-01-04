import ComponentsStoreMx from './ComponentsStoreMx';

import {
    CID_THE_MAP_CONTAINER,
    STORE_M_COMPONENTS_G_COMPONENT_PROP,
    STORE_M_COMPONENTS_M_COMPONENT_PROP,
    PK_CURRENT_ADMIN_BOUNDS_LAYER,
    PK_CURRENT_BASE_MAP,
    PK_CURRENT_BING_IMAGERY_SET,
    PK_CURRENT_LAYER,
    PK_SELECTED_FEATURES
} from '../utils/constants';

export default {
    mixins: [
        ComponentsStoreMx
    ],
    computed: {
        mapContainerComponentStoreMx_currentBaseMap: {
            get() {
                return this[STORE_M_COMPONENTS_G_COMPONENT_PROP](CID_THE_MAP_CONTAINER, PK_CURRENT_BASE_MAP);
            },
            set(value) {
                this.componentStoreMx_mutation(STORE_M_COMPONENTS_M_COMPONENT_PROP, {
                    cid: CID_THE_MAP_CONTAINER,
                    prop: PK_CURRENT_BASE_MAP,
                    value: value
                });
            }
        },
        mapContainerComponentStoreMx_currentBingImagerySet: {
            get() {
                return this[STORE_M_COMPONENTS_G_COMPONENT_PROP](CID_THE_MAP_CONTAINER, PK_CURRENT_BING_IMAGERY_SET);
            },
            set(value) {
                this.componentStoreMx_mutation(STORE_M_COMPONENTS_M_COMPONENT_PROP, {
                    cid: CID_THE_MAP_CONTAINER,
                    prop: PK_CURRENT_BING_IMAGERY_SET,
                    value: value
                });
            }
        },
        mapContainerComponentStoreMx_currentLayer: {
            get() {
                return this[STORE_M_COMPONENTS_G_COMPONENT_PROP](CID_THE_MAP_CONTAINER, PK_CURRENT_LAYER);
            },
            set(value) {
                this.componentStoreMx_mutation(STORE_M_COMPONENTS_M_COMPONENT_PROP, {
                    cid: CID_THE_MAP_CONTAINER,
                    prop: PK_CURRENT_LAYER,
                    value: value
                });
            }
        },
        mapContainerComponentStoreMx_currentAdminBoundsLayer: {
            get() {
                return this[STORE_M_COMPONENTS_G_COMPONENT_PROP](CID_THE_MAP_CONTAINER, PK_CURRENT_ADMIN_BOUNDS_LAYER);
            },
            set(value) {
                this.componentStoreMx_mutation(STORE_M_COMPONENTS_M_COMPONENT_PROP, {
                    cid: CID_THE_MAP_CONTAINER,
                    prop: PK_CURRENT_ADMIN_BOUNDS_LAYER,
                    value: value
                });
            }
        },
        mapContainerComponentStoreMx_selectedFeatures: {
            get() {
                return this[STORE_M_COMPONENTS_G_COMPONENT_PROP](CID_THE_MAP_CONTAINER, PK_SELECTED_FEATURES);
            },
            set(value) {
                this.componentStoreMx_mutation(STORE_M_COMPONENTS_M_COMPONENT_PROP, {
                    cid: CID_THE_MAP_CONTAINER,
                    prop: PK_SELECTED_FEATURES,
                    value: value
                });
            }
        },
    }
};
