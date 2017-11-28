import * as types from '../mutation-types'

const state = {
    blueprints: {},
    current: null,
    rows: {
        data: {},
        links: {},
        meta: {}
    },
    data: {}
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
    },
    getCurrentBlueprint: state => {
        return state.current
    },
    getRows: state => {
        return state.rows.data
    },
    getPagination: state => {
        return state.rows.meta
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
    getDataRows ({ commit, getters }, {blueprint, paginate}) {
        if (blueprint) {
            const page = !paginate ? '' :`?page=${paginate}`
            return $http.get(`api/model/${ blueprint }/data${page}`)
                        .then(response => {
                            commit(types.MODEL_ROWS, response.data)
                        });
        } else {
            return new Promise((resolve, reject) => {
                resolve(false)
            })
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
    [types.MODEL_ROWS] (state, rows) {
        state.rows.data = rows.data
        state.rows.links = rows.links
        state.rows.meta = rows.meta
        //{state.rows.data, state.rows.links, state.rows.meta} = {rows.data, rows.links, rows.meta}
    },
    
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
