import * as types from '../mutation-types'

const state = {
    isOpen: false,
    list: {}
}

const actions = {
    setList ({ commit }, list) {
        commit(types.SIDEBAR_LIST, list)
    },
    toggle ({ commit }) {
        commit(types.SIDEBAR_TOGGLE)
    },
    close ({ commit }) {
        commit(types.SIDEBAR_CLOSE)
    }
}

const mutations = {
    [types.SIDEBAR_LIST] (state, list) {
        state.list = list
    },
    [types.SIDEBAR_TOGGLE] (state) {
        state.isOpen = !state.isOpen
    },
    [types.SIDEBAR_CLOSE] (state) {
        state.isOpen = false
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
