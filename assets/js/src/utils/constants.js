import kebabCase from 'lodash/kebabCase';

// "__root__" store
export const STORE_M_ROOT_A_ENV_DATA = 'setStoreEnvDataAction';
export const STORE_M_ROOT_M_BING_API_KEY = 'setStoreBingApiKeyMutation';

// "components" store module
export const STORE_M_COMPONENTS_G_COMPONENT = 'getStoreModComponentsComponentsGetter';
export const STORE_M_COMPONENTS_G_COMPONENT_PROP = 'getStoreModComponentsComponentPropGetter';
export const STORE_M_COMPONENTS_M_CREATE_COMPONENT = 'createStoreModComponentsComponentsMutation';
export const STORE_M_COMPONENTS_M_COMPONENT_PROP = 'setStoreModComponentsComponentPropMutation';
export const STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP = 'toggleStoreModComponentsComponentPropMutation';

// "geoserver" store module
export const STORE_M_GS_M_BASE_URL = 'setStoreModGeoServerBaseUrlMutation';

// "geoserver/auth" store module
export const STORE_M_GS_AUTH_G_GUEST_AUTH = 'setStoreModGeoServerAuthGuestAuthGetter';
export const STORE_M_GS_AUTH_M_GUEST_TOKEN = 'setStoreModGeoServerAuthGuestTokenMutation';

// components ID aka "cid"
export const CID_THE_MAIN_NAVIGATION_DRAWER = 'TheMainNavigationDrawer';
export const CID_THE_MAIN_TOP_TOOLBAR = 'TheMainTopToolbar';
export const CID_THE_MAP_CONTAINER = 'TheMapContainer';
export const CID_THE_MAP_LAYERS_DRAWER = 'TheMapLayersDrawer';
export const CID_THE_MAP_PROPERTIES_DRAWER = 'TheMapPropertiesDrawer';
export const CID_THE_MAP_TOOLBAR = 'TheMapToolbar';
export const CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0 = 'MapLayerVectorWfsAdminBounds0';
export const CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1 = 'MapLayerVectorWfsAdminBounds1';
export const CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2 = 'MapLayerVectorWfsAdminBounds2';

// property keys
export const PK_CURRENT_BASE_MAP = 'currentBaseMap';
export const PK_CURRENT_BING_IMAGERY_SET= 'currentBingImagerySet';
export const PK_CURRENT_ADMIN_BOUNDS_LAYER= 'currentAdminBoundsLayer';
export const PK_CURRENT_LAYER = 'currentLayer';
export const PK_SELECTED_FEATURES = 'selectedFeatures';

// data-test attribute values
export const DT_THE_MAP_CONTAINER = kebabCase(DT_THE_MAP_CONTAINER);
export const DT_THE_MAP_LAYERS_DRAWER = kebabCase(CID_THE_MAP_LAYERS_DRAWER);
export const DT_THE_MAP_PROPERTIES_DRAWER = kebabCase(CID_THE_MAP_PROPERTIES_DRAWER);
export const DT_THE_MAP_TOOLBAR = kebabCase(CID_THE_MAP_TOOLBAR);
export const DT_THE_MAP_TOOLBAR_LEFT_SIDE_ICON = `${DT_THE_MAP_TOOLBAR}-left-side-icon`;
export const DT_THE_MAP_TOOLBAR_PROPERTIES_BUTTON = `${DT_THE_MAP_TOOLBAR}-properties-button`;
