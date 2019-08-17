import {
    WFS_TYPENAME_VW_SITES_SURVEY,
    WFS_TYPENAME_VW_SITES_RS,
    TITLE_TYPENAME_VW_SITES_SURVEY,
    TITLE_TYPENAME_VW_SITES_RS,
    TITLE_TYPENAME_VW_SITES
} from '@/utils/cids';

export default {
    props: {
        layerId: {
            type: String,
            required: true
        }
    },
    computed: {
        title() {
            const titles = {
                [WFS_TYPENAME_VW_SITES_SURVEY]: TITLE_TYPENAME_VW_SITES_SURVEY,
                [WFS_TYPENAME_VW_SITES_RS]: TITLE_TYPENAME_VW_SITES_RS,
            };
            return titles[this.layerId] || TITLE_TYPENAME_VW_SITES;
        }
    }
};
