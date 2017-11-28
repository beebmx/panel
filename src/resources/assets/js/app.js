require('./bootstrap');

import Vue from 'vue';
import axios from 'axios'
import vuexI18n from 'vuex-i18n';
import store from './store'
import router from './router'

import './layouts'
import './panel'
import './ui'
import App from './App.vue'

import { mapActions } from 'vuex'

Vue.prototype.$http = axios.create({
    baseURL: panel.baseURL,
    headers: {'X-CSRF-TOKEN': panel.token}
});

Vue.use(vuexI18n.plugin, store);

new Vue({
    el: '#root',
    router,
    store,
    render: h => h(App),
    methods: {
        setSettings(settings) {
            this.$store.dispatch('general/setSettings', settings);
        },
        setList(list) {
            this.$store.dispatch('sidebar/setList', list);
        }
    },
    created() {
        this.$http.get(`api`)
            .then(response => {
                const data = response.data;
                this.setSettings(data.settings);
                this.setList(data.list);
            });
    }
});

// new Vue({
//     el: '#sidebar',
//     store,
//     computed: mapGetters({
//         isOpen: 'sbStatus'
//     }),
//     methods: {
//         slideBarToggle: () => store.dispatch('sbToggle'),
//         closeSideBar: () => store.dispatch('sbClose'),
//         hasClass: (e, cName) => {
//             const rg = new RegExp("(^|\\s+)" + cName + "(\\s+|$)");
//             return rg.test(e.className);

//         },
//         closeSideBarIfOpen: (event) => {
//             const e = event.target,
//                   testCurrent = new RegExp("(^|\\s+)" + e.className + "(\\s+|$)").test('panel-menu'),
//                   testParent = new RegExp("(^|\\s+)" + e.parentNode.className + "(\\s+|$)").test('panel-menu');
//             if (!testCurrent && !testParent) {
//                 store.dispatch('sbClose');
//             }
//         },
//         closeSideBarOnEsc: (event) => {
//             if (event.keyCode === 27) {
//                 store.dispatch('sbClose');
//             }
//         }
//     },
//     watch: {
//         isOpen: function (val) {
//             if (val) {
//                 setTimeout(() => {
//                     document.addEventListener('click', this.closeSideBarIfOpen);
//                     document.addEventListener('keyup', this.closeSideBarOnEsc);
//                 }, 350);
                
//             } else {
//                 document.removeEventListener('click', this.closeSideBarIfOpen);
//                 document.removeEventListener('keyup', this.closeSideBarOnEsc);
//             }
//         }
//     },
//     mounted() {
//         window.addEventListener('resize', () => {
//             if (window.innerWidth > 769) {
//                 store.dispatch('sbClose');
//             }
//         });
        
//     },
//     beforeDestroy() {
//         window.removeEventListener('resize');
//     }
// })
