window.axios = require('axios');
window._ = require('lodash');

window.$http = axios.create({
    baseURL: panel.baseURL,
    headers: {'X-CSRF-TOKEN': panel.token}
});

