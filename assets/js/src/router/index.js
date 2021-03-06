import Vue from 'vue';
import Router from 'vue-router';
import store from '@/store';
import NestedRouterViewPlaceholder from '@/components/NestedRouterViewPlaceholder';
import ContributeUpload from '@/components/ContributeUpload';
import TheMapContainer from '@/components/TheMapContainer';
import TheLoginModal from '@/components/TheLoginModal';
import TheLogoutModal from '@/components/TheLogoutModal';
import TheDataContainer from '@/components/TheDataContainer';
import DataCardContainer from '@/components/DataCard/DataCardContainer';
import MapToolbarButtons from '@/components/MapToolbarButtons';
import MapFooterData from '@/components/MapFooterData';
import MapDrawerEntries from '@/components/MapDrawerEntries';
import {QUERY_TYPENAME_VW_SITES_SURVEY, QUERY_TYPENAME_VW_SITES_RS} from '@/utils/cids';
import {displaySnackbarFn} from '@/mixins/SnackbarComponentStoreMx';
import {isAuthenticated} from '@/store/auth/getters';
import ContributeUploadStatus from '@/components/ContributeUploadStatus';

/**
 * @typedef {import('@/mixins/SnackbarComponentStoreMx')} SnackbarOptions
 * @see '@/mixins/SnackbarComponentStoreMx'
 */

/**
 * @typedef {Object} RouteGuardOptions
 * @property {*} _next - The next function argument
 * @property {SnackbarOptions} _snackbar - The snackbar options
 */

Vue.use(Router);

export const dataTableRoutes = [
    {
        path: `:queryTypename(${QUERY_TYPENAME_VW_SITES_SURVEY}|${QUERY_TYPENAME_VW_SITES_RS})/:action(list)`,
        name: 'map_data_vw-site_list',
        components: {
            default: DataCardContainer
        },
        props: {
            default: true
        }
    },
    {
        path: `:queryTypename(${QUERY_TYPENAME_VW_SITES_SURVEY}|${QUERY_TYPENAME_VW_SITES_RS})/:itemId(\\d+)/:action(read)`,
        name: 'map_data_vw-site_read',
        components: {
            default: DataCardContainer
        },
        props: {
            default: true
        }
    },
    {
        path: `:queryTypename(${QUERY_TYPENAME_VW_SITES_SURVEY}|${QUERY_TYPENAME_VW_SITES_RS})/:itemId(\\d+)/:action(edit)`,
        name: 'map_data_vw-site_edit',
        components: {
            default: DataCardContainer,
        },
        props: {
            default: true
        },
        meta: {
            requiresRole: 'editor',
        }
    },
];

export const contributeRoutes = {
    path: '/:prefix(contribute)',
    components: {
        default: TheDataContainer,
    },
    props: {
        default: true,
        map: false
    },
    children: [
        {
            path: 'upload/:type(survey|remote-sensing)/:format(zip-shapefile)',
            name: 'contribute_upload',
            components: {
                default: ContributeUpload
            },
            props: {
                default: true
            },
            meta: {
                requiresRole: 'editor',
            }
        },
        {
            path: ':id/status',
            name: 'contribute_status',
            components: {
                default: ContributeUploadStatus
            },
            props: {
                default: true
            }
        }
    ],
};

export const dataRoutes = {
    path: '/:prefix(data)',
    components: {
        default: TheDataContainer,
        map: TheMapContainer
    },
    props: {
        default: true,
        map: false
    },
    children: dataTableRoutes
};

export const mapDataRoutes = {
    path: ':prefix(data)',
    name: 'map_data_container',
    components: {
        default: TheDataContainer,
    },
    props: {
        default: true,
        map: false
    },
    children: dataTableRoutes
};

const scrollBehavior = function(to, from, savedPosition) {
    if (savedPosition) {
        // savedPosition is only available for popstate navigations.
        return savedPosition;
    } else {


        // scroll to anchor by returning the selector
        if (to.hash) {
            return new Promise((resolve) => {
                setTimeout(() => {
                    /*const position = {};
                    position.selector = to.hash;

                    resolve(position);*/
                    const position = window.scrollTo({ top: document.querySelector(to.hash).offsetTop, behavior: 'smooth' });
                    resolve(position);
                }, 500);
            });

        }
    }
};

let router = new Router({
    scrollBehavior,
    routes: [
        {
            path: '/',
            redirect: { name: 'map' }
        },
        {
            path: '/map',
            name: 'map',
            components: {
                default: NestedRouterViewPlaceholder,
                drawer: MapDrawerEntries,
                map: TheMapContainer,
                toolbar: MapToolbarButtons,
                footer: MapFooterData
            },
            children: [
                mapDataRoutes
            ]
        },
        contributeRoutes,
        {
            path: '/login',
            name: 'login',
            components: {
                modal: TheLoginModal
            }
        },
        {
            path: '/logout',
            name: 'logout',
            components: {
                modal: TheLogoutModal
            },
            meta: {
                requiresAuthenticated: true,
                silentFail: true
            }
        },
    ]
});

/**
 *
 * @param to
 * @param from
 * @param next
 * @return {RouteGuardOptions}
 */
const authenticatedRoutedHandler = (to, from, next) => {
    let _return = {};
    const route = to.matched[0];
    if (!isAuthenticated(store.getters)) {
        if (route.meta.silentFail) {
            _return._next = false;
        } else {
            _return._next = {
                path: '/login',
                query: { redirect: to.fullPath }
            };
            _return._snackbar = {
                text: 'You must authenticate to access this content',
                color: 'warning'
            };
        }
    }
    return _return;
};

export function beforeEach(to, from, next) {
    /**
     * @var * - The next function argument
     * @see https://router.vuejs.org/guide/advanced/navigation-guards.html#global-before-guards
     */
    let _next;
    /**
     * @var {SnackbarOptions}
     */
    let _snackbar = {};

    const displaySnackbar = displaySnackbarFn(store);
    if (to.matched.length === 0) {
        _snackbar = {
            text: 'Requested resource does not exist',
            color: 'warning'
        };
        _next = false;
    }
    if (typeof(_next) === 'undefined' && to.matched.some(record => record.meta.requiresAuthenticated)) {
        ({_next, _snackbar = {}} = authenticatedRoutedHandler(to, from, next));
    }
    if (typeof(_next) === 'undefined' && to.matched.some(record => record.meta.hasOwnProperty('requiresRole'))) {
        ({_next, _snackbar = {}} = authenticatedRoutedHandler(to, from, next));
    }
    if (Object.keys(_snackbar).length) {
        displaySnackbar(_snackbar);
    }
    next(_next);
}

router.beforeEach((to, from, next) => beforeEach(to, from, next));

export default router;
