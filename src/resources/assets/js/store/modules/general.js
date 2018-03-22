import * as types from '../mutation-types'

const state = {
    panel: {}
}

const getters = {
    getBase (state) {
        return state.panel.base
    }
}

const actions = {
    setSettings ({ commit }, settings) {
        commit(types.GENERAL_SETTINGS, settings)
    },
}

const mutations = {
    [types.GENERAL_SETTINGS] (state, settings) {
        state.panel = settings
    },
    
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
