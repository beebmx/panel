import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    base: `/${ panel.base }/`,
    linkActiveClass: 'is-active',
    routes: [
        {
            path: '/',
            name: 'dashboard',
            component: require('../views/Dashboard.vue'),
        },{
            path: '/model/:blueprint/:parent(\\d+)?',
            component: require('../views/model/Index.vue'),
            children: [
                {
                    path: '/',
                    name: 'model.index',
                    component: require('../views/model/List.vue'),
                },
                {
                    path: 'create',
                    name: 'model.create',
                    component: require('../views/model/Form.vue'),
                    props: {type: 'create'}
                },
                {
                    path: ':id(\\d+)/edit',
                    name: 'model.edit',
                    component: require('../views/model/Form.vue'),
                    props: {type: 'update'}
                }
            ]
        }
    ]
});
