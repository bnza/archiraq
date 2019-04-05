
import Vue from 'vue';
import Router from 'vue-router';
import TheMapContainer from '../components/TheMapContainer';
import TheLoginModal from '../components/TheLoginModal';
import TheLogoutModal from '../components/TheLogoutModal';
import TheDataContainer from '../components/TheDataContainer';
import DataCardContainer from '../components/DataCard/DataCardContainer';

Vue.use(Router);

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
    children: [
        {
            path: ':typename(vw-site)/:action(list)',
            components: {
                default: DataCardContainer
            },
            props: {
                default: true
            }
        }
    ]
};

let router = new Router({
    routes: [
        {
            path: '/',
            name: 'home',
            components: {
                // default: TheHomepageContent,
                map: TheMapContainer
            }
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
        dataRoutes,
    ]
});

export default router;
