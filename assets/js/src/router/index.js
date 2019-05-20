
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
import MapDrawerEntries from '../components/MapDrawerEntries';
import {QUERY_TYPENAME_VW_SITES} from '@/utils/cids';

Vue.use(Router);

export const dataTableRoutes = [
    {
        path: `:typename(${QUERY_TYPENAME_VW_SITES})/:action(list)`,
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
