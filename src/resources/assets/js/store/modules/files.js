import * as types from '../mutation-types'

const state = {
    files: [],
    progress: 0
}

const getters = {
    all (state) {
        return state.files
    },
    visible (state) {
        return _.filter(state.files, file => {
            return file.status !== 'deleted'
        });
    },
    getProgress (state) {
        return state.progress
    },
    getByType: (state) => (type) => {
        if (type === 'files') {
            return _.filter(state.files, file => {
                return file.status !== 'deleted'
            });
        } else {
            return _.filter(state.files, file => {
                return file.status !== 'deleted' && file.type === type
            });
        }
    }
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
                _.forEach(response.data.data, file => {
                    file.status = 'pending'
                    file.location = 'tmp'
                    if (typeof _.find(getters.files, { 'filename': file.filename }) === 'undefined') {
                        commit(types.FILES_ADD, file)
                    } else {
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
                _.forEach(response.data.data, file => {
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
                    _.forEach(response.data.data, file => {
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
    reverse ({commit, state}, url) {
        $http.post(`${url}/reverse`, {files:state.files})
             .then(response => {
                 commit(types.FILES_SET, {})
                 return response.data
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
        state.files = [];
        _.each(files, file => {
            state.files.push(file)
        })
    },
    [types.FILES_ADD] (state, file) {
        state.files.push(file)
    },
    [types.FILES_REPLACE] (state, file) {
        state.files[file.filename] = file
    },
    [types.FILES_DELETE] (state, file) {
        console.log(_.findIndex(state.files, {'filename':file}), file)
        state.files[_.findIndex(state.files, {'filename':file})].status = 'deleted'
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
