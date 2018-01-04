import Vue from 'vue'
import Vuex from 'vuex'
//import * as states from './states'
//import * as actions from './actions'
//import * as getters from './getters'
//import * as mutations from './mutations'
import files from './modules/files'
import general from './modules/general'
import model from './modules/model'
import sidebar from './modules/sidebar'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    //state:{},
    //actions:{},
    //getters:{},
    //mutations:{},
    //
    //states
    //actions
    //getters
    //mutations
    modules: {
        files,
        general,
        model,
        sidebar
    },
    strict: debug
})