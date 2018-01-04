import * as types from '../mutation-types'

const state = {
    files: {},
    progress: 0
}

const getters = {
    all (state) {
        return state.files
    },
    getProgress (state) {
        return state.progress
    },
}

const actions = {
    upload ({commit, getters}, {url, files}) {
        const config = {
            onUploadProgress: function(progressEvent) {
                let progress = Math.round( (progressEvent.loaded * 100) / progressEvent.total )
                commit(types.FILES_PROGRESS, progress)
            }
        }
        const data = new FormData();
        _.forEach(files, (file, i) => {
            data.append(`files[${i}]`, file);
        });

        $http.post(url, data, config)
             .then(response => {
                _.forEach(response.data.files, file => {
                    if (typeof _.find(getters.files, { 'filename': file.filename }) === 'undefined') {
                        file.status = 'pending'
                        file.location = 'tmp'
                        commit(types.FILES_ADD, file)
                    } else {
                        file.status = 'pending'
                        file.location = 'tmp'
                        commit(types.FILES_REPLACE, file)
                    }
                })
                commit(types.FILES_PROGRESS, 0)
             })
             .catch(error => {
                console.log(error, error.message)
             });
    },
    remote ({commit}, url) {
        $http.get(url)
             .then(response => {
                 let files = {};
                _.forEach(response.data.files, file => {
                    file.status = 'remote'
                    file.location = 'remote'
                    files[file.filename] = file
                })
                commit(types.FILES_SET, files)
            })
    },
    process ({commit, state}, url) {
        return new Promise((resolve, reject) => {
            $http.post(`${url}/process`, {files:state.files})
                 .then(response => {
                    let files = {};
                    _.forEach(response.data.files, file => {
                        file.status = 'remote'
                        file.location = 'remote'
                        files[file.filename] = file
                    })
                    commit(types.FILES_SET, files)
                    resolve (files)
                 })
                 .catch(error => {
                    reject (error)
                 });
        })
    },
    reverse ({state}, url) {
        $http.post(`${url}/reverse`, {files:state.files})
             .then(response => {
                console.log(response.data)
             })
             .catch(error => {
                console.log(error)
             });
    }
}

const mutations = {
    [types.FILES_PROGRESS] (state, progress) {
        state.progress = progress
    },
    [types.FILES_SET] (state, files) {
        state.files = files
    },
    [types.FILES_ADD] (state, file) {
        state.files[file.filename] = file
    },
    [types.FILES_REPLACE] (state, file) {
        state.files[file.filename] = file
    },
    [types.FILES_DELETE] (state, file) {
        state.files[file].status = 'deleted'
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
