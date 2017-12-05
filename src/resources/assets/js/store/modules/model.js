import * as types from '../mutation-types'

const state = {
    loading: false,
    blueprints: {},
    current: null,
    rows: {
        data: {},
        links: {},
        meta: {}
    },
    relationships: {},
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
    getFields: state => {
        if (typeof state.blueprints[state.current] !== 'undefined') {
            return state.blueprints[state.current].fields
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
    },
    getDataFields: state => {
        return state.data
    },
    getRelationship: state => (relationship) => {
        return state.relationships[relationship];
    }
}

const actions = {
    setModel ({ commit, getters }, blueprint) {
        if (!getters.hasModel(blueprint)) {
            commit(types.MODEL_LOADING, true)
            $http.get(`api/model/${ blueprint }`)
                 .then((response) => {
                    commit(types.MODEL_LOADING, false)
                    commit(types.MODEL_ADD, {blueprint:blueprint, data:response.data})
                    commit(types.MODEL_CURRENT, blueprint)
                 })
        } else {
            commit(types.MODEL_CURRENT, blueprint)
        }
    },
    getDataRows ({ commit }, {blueprint, paginate}) {
        if (blueprint) {
            const page = !paginate ? '' :`?page=${paginate}`
            commit(types.MODEL_LOADING, true)
            return $http.get(`api/model/${ blueprint }/data${page}`)
                        .then(response => {
                            commit(types.MODEL_LOADING, false)
                            commit(types.MODEL_ROWS, response.data)
                        });
        } else {
            return new Promise((resolve, reject) => {
                resolve(false)
            })
        }
    },
    getData ({ commit }, {blueprint, id}) {
        id = id || 0;
        return $http.get(`api/model/${ blueprint }/${id}`)
            .then(response => {
                commit(types.MODEL_RELATIONSHIPS, response.data.models)
                commit(types.MODEL_RECORD, response.data.data)
            })
            .catch(error => {
                console.log(error)
            });
    }
}

const mutations = {
    [types.MODEL_LOADING] (state, loading) {
        state.loading = loading
    },
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
    },
    [types.MODEL_RELATIONSHIPS] (state, relationships) {
        state.relationships = relationships
    },
    [types.MODEL_RECORD] (state, data) {
        state.data = data
    },
    [types.MODEL_UPDATE_FIELD] (state, record) {
        state.data[record.id] = record.value
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
