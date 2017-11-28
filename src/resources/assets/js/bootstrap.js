window.axios = require('axios');

window.$http = axios.create({
    baseURL: panel.baseURL,
    headers: {'X-CSRF-TOKEN': panel.token}
});

