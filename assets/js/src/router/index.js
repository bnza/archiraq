import Vue from 'vue'
import Router from 'vue-router'

import TheMapContainer from '../components/TheMapContainer'
import TheHomepageContent from '../components/TheHomepageContent'

Vue.use(Router)

let router = new Router({
    routes: [
        {
            path: '/',
            name: 'home',
            components: {
                default: TheHomepageContent,
                map: TheMapContainer
            }
        }
    ]
})

export default router