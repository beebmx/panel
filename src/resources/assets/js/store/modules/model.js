import * as types from '../mutation-types'

const state = {
    blueprints: {},
    current: null
}

const getters = {
    hasModel: (state) => (blueprint) => {
        if (state.blueprints[blueprint]) {
            return true
        } else {
            return false
        }
    },
    getHeaders: state => {
        if (typeof state.blueprints[state.current] !== 'undefined') {
            return state.blueprints[state.current].headers
        } else {
            return {}
        }
    },
    getPermissions: state => {
        if (typeof state.blueprints[state.current] !== 'undefined') {
            return state.blueprints[state.current].permissions
        } else {
            return {}
        }
    }
}

const actions = {
    setModel ({ commit, getters }, blueprint) {
        if (!getters.hasModel(blueprint)) {
            $http.get(`api/model/${ blueprint }`)
                 .then((response) => {
                    commit(types.MODEL_ADD, {blueprint:blueprint, data:response.data})
                    commit(types.MODEL_CURRENT, blueprint)
                 })
        } else {
            commit(types.MODEL_CURRENT, blueprint)
        }
    },
}

const mutations = {
    [types.MODEL_ADD] (state, model) {
        state.blueprints[model.blueprint] = model.data
    },
    [types.MODEL_CURRENT] (state, current) {
        state.current = current
    },
    
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
