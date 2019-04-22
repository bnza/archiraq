
import Vue from 'vue';
import Router from 'vue-router';
import NestedRouterViewPlaceholder from '../components/NestedRouterViewPlaceholder';
import TheMapContainer from '../components/TheMapContainer';
import TheLoginModal from '../components/TheLoginModal';
import TheLogoutModal from '../components/TheLogoutModal';
import TheDataContainer from '../components/TheDataContainer';
import DataCardContainer from '../components/DataCard/DataCardContainer';
import MapToolbarButtons from '../components/MapToolbarButtons';
import MapFooterData from '../components/MapFooterData';

Vue.use(Router);

export const dataTableRoutes = [
    {
        path: ':typename(vw-site)/:action(list)',
        name: 'map_data_vw-site_list',
        components: {
            default: DataCardContainer
        },
        props: {
            default: true
        }
    }
];

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

let router = new Router({
    scrollBehavior: function(to, from, savedPosition) {
        if (savedPosition) {
            // savedPosition is only available for popstate navigations.
            return savedPosition;
        } else {
            const position = {};

            // scroll to anchor by returning the selector
            if (to.hash) {
                position.selector = to.hash;

                // if the returned position is falsy or an empty object,
                // will retain current scroll position.
                return position;
            }
        }
    },
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
                map: TheMapContainer,
                toolbar: MapToolbarButtons,
                footer: MapFooterData
            },
            children: [
                mapDataRoutes
            ]
        },
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
            }
        },
    ]
});

router.beforeEach((to, from, next) => {
    next();
});

export default router;
