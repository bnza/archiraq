export const CID_BING_BASE_MAP_SETTINGS_DIALOG_LAYOUT = 'BingBaseMapSettingsDialog';
export const CID_MAP_LAYER_GROUP_ADMIN_BOUNDS = 'MapLayerGroupAdminBounds';
export const CID_MAP_LAYER_SETTINGS_DIALOG = 'MapLayerSettingsDialog';
export const CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0 = 'MapLayerVectorWfsAdminBounds0';
export const CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1 = 'MapLayerVectorWfsAdminBounds1';
export const CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2 = 'MapLayerVectorWfsAdminBounds2';
export const CID_MAP_LAYER_VECTOR_WFS_VW_SITES = 'MapLayerVectorWfsVwSite';
export const CID_MAP_LAYER_VECTOR_WFS_VW_SITES_RS = 'MapLayerVectorWfsVwSiteRs';
export const CID_MAP_LAYER_VECTOR_WFS_VW_SITES_SURVEY = 'MapLayerVectorWfsVwSiteSurvey';
export const CID_THE_MAIN_NAVIGATION_DRAWER = 'TheMainNavigationDrawer';
export const CID_THE_MAP_CONTAINER = 'TheMapContainer';
export const CID_THE_MAIN_TOOLBAR = 'TheMainToolbar';
export const CID_THE_MAP_FOOTER = 'TheMapFooter';
export const CID_THE_MAP_LAYERS_DRAWER = 'TheMapLayersDrawer';
export const CID_THE_MAP_TOOLBAR = 'TheMapToolbar';
export const CID_THE_SNACKBAR = 'TheSnackbar';
export const CID_VW_SITE_LIST_DATA_CARD = 'VwSiteListDataCard';
export const CID_VW_SITE_READ_DATA_CARD = 'VwSiteReadDataCard';
export const CID_VW_SITE_EDIT_DATA_CARD = 'VwSiteEditDataCard';
export const CID_VW_SITE_INTERACTION_MODIFY = 'VwSiteInteractionModify';
export const CID_VW_SITE_SURVEY_LIST_DATA_CARD = 'VwSiteSurveyListDataCard';
export const CID_VW_SITE_RS_LIST_DATA_CARD = 'VwSiteRsListDataCard';

export const QUERY_TYPENAME_VW_SITES = 'vw-site';
export const QUERY_TYPENAME_VW_SITES_SURVEY = 'vw-site-survey';
export const QUERY_TYPENAME_VW_SITES_RS = 'vw-site-rs';
export const QUERY_TYPENAME_VW_SITES_EDIT = 'vw-site-edit';

export const WFS_TYPENAME_VW_SITES_SURVEY = 'vw_site_survey';
export const WFS_TYPENAME_VW_SITES_RS = 'vw_site_rs';
export const WMTS_TYPENAME_CORONA_FORE = 'corona_fore';
export const WMTS_TYPENAME_CORONA_AFT = 'corona_aft';
export const WMTS_TYPENAME_SURVEY_TOPO_01_AKKAD = 'cv_survey_topo_01_akkad';
export const WMTS_TYPENAME_SURVEY_TOPO_02_LBB = 'cv_survey_topo_02_lbb';
export const WMTS_TYPENAME_SURVEY_TOPO_03_HOC = 'cv_survey_topo_03_hoc';
export const WMTS_TYPENAME_SURVEY_TOPO_07_UR = 'cv_survey_topo_07_ur';
export const WMTS_TYPENAME_SURVEY_TOPO_10_HAMMAR = 'cv_survey_topo_10_hammar';
export const WMTS_TYPENAME_SURVEY_TOPO_11_MANDALI = 'cv_survey_topo_11_mandali';
export const WMTS_TYPENAME_SURVEY_TOPO_12_MYINAB = 'cv_survey_topo_12_myinab';
export const WMTS_TYPENAME_SURVEY_TOPO_13_SWIRAN = 'cv_survey_topo_13_sw_iran';
export const WMTS_TYPENAME_SURVEY_TOPO_14_HORMUZ = 'cv_survey_topo_14_hormuz';

export const TITLE_TYPENAME_VW_SITES = 'Sites';
export const TITLE_TYPENAME_VW_SITES_SURVEY = 'Sites (survey)';
export const TITLE_TYPENAME_VW_SITES_RS = 'Sites (remote sensing)';

export const HEADERS_VW_SITE_LIST_DATA_CARD_TABLE = {
    [QUERY_TYPENAME_VW_SITES_SURVEY]: [
        {
            text: 'id',
            value: 'id'
        },
        {
            text: 'SBAH (no)',
            value: 'sbah_no'
        },
        {
            text: 'cadastre',
            value: 'cadastre'
        },
        {
            text: 'modern name',
            value: 'modern_name'
        },
        {
            text: 'nearest city',
            value: 'nearest_city'
        },
        {
            text: 'ancient name',
            value: 'ancient_name'
        },
        {
            text: 'district',
            value: 'district'
        },
        {
            text: 'governorate',
            value: 'governorate'
        },
        {
            text: 'nation',
            value: 'nation'
        },
        {
            text: 'chronology',
            value: 'chronology'
        },
        {
            text: 'surveys',
            value: 'survey_refs'
        },
        {
            text: 'features',
            value: 'features'
        },
        {
            text: 'threats',
            value: 'threats'
        },
        {
            text: 'E',
            value: 'e'
        },
        {
            text: 'N',
            value: 'n'
        },
        {
            text: 'length (m)',
            value: 'length'
        },
        {
            text: 'width (m)',
            value: 'width'
        },
        {
            text: 'area (ha)',
            value: 'area'
        },
        {
            text: 'remarks',
            value: 'remarks'
        },
    ],
    [QUERY_TYPENAME_VW_SITES_RS]: [
        {
            text: 'id',
            value: 'id'
        },
        {
            text: 'modern name',
            value: 'modern_name'
        },
        {
            text: 'ancient name',
            value: 'ancient_name'
        },
        {
            text: 'district',
            value: 'district'
        },
        {
            text: 'governorate',
            value: 'governorate'
        },
        {
            text: 'nation',
            value: 'nation'
        },
        {
            text: 'threats',
            value: 'threats'
        },
        {
            text: 'E',
            value: 'e'
        },
        {
            text: 'N',
            value: 'n'
        },
        {
            text: 'length (m)',
            value: 'length'
        },
        {
            text: 'width (m)',
            value: 'width'
        },
        {
            text: 'area (ha)',
            value: 'area'
        },
        {
            text: 'remarks',
            value: 'remarks'
        },
    ]
};


