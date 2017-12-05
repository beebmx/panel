require('./bootstrap');

import Vue from 'vue';
import axios from 'axios'
import vuexI18n from 'vuex-i18n';
import store from './store'
import router from './router'
import VueProgressBar from 'vue-progressbar'

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
const progressOptions = {
    color: 'hsl(141, 71%, 48%)',
    failedColor: 'hsl(348, 100%, 61%)'
}
Vue.use(VueProgressBar, progressOptions)

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

