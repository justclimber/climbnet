const axios = require('axios');

class Api {
    constructor(urlPrefix) {
        this.urlPrefix = urlPrefix;

    }

    get(url) {
        return axios.get(this.urlPrefix + url);
    }

    getById(url, id) {
        return axios.get(this.urlPrefix + url + '/' + id);
    }

    save(url, data) {
        if (data.id) {
            return axios.put(this.urlPrefix + url + '/' + data.id, data);
        } else {
            return axios.post(this.urlPrefix + url, data);
        }
    }
}

export default Api;