function ApiObject(url, errorsObject) {
    var storage;
    var self = this;
    errorsObject = errorsObject === undefined ? {message:"", errors: []} : errorsObject;
    function cleanErrors() {
        Vue.set(errorsObject, 'message', "");
        Vue.set(errorsObject, 'errors', []);
    }
    this.listenStorage = (data) => {
        for (var attr in data) {
            Vue.set(self, attr, data[attr]);
        }
    };
    this.listenErrors = (error) => {
        for(var a in error) {
            Vue.set(errorsObject, a, error[a]);
        }
    };
    self.loadFromAPI = function(newURL) {
        cleanErrors();
        if (newURL !== undefined) {
            storage.unregister(this);
            storage = new ApiStorage(newURL, this);
        } else {
            storage.update();
        }
    };
    self.postToAPI = function(url) {
        cleanErrors();
        var attributes = Object.assign({}, this.attributes);
        delete attributes.id;
        return window.axios.post(url, {
            data: {
                attributes: attributes
            }
        }).catch(error => {
            this.listenErrors(error.response.data);
        });
    };
    self.putToAPI = function(url) {
        cleanErrors();
        var attributes = Object.assign({}, this.attributes);
        return window.axios.put(url, {
            data: {
                attributes: attributes
            }
        }).catch(error => {
            this.listenErrors(error.response.data);
        });
    };
    storage = new ApiStorage(url, this);
    cleanErrors();
    return self;
}
Object.evaluateRef = function(item, path) {
    if (item === undefined) {
        return item;
    }
    if (typeof path === 'string') {
        return Object.evaluateRef(item, path.split('.'));
    }
    if (!(path instanceof Array)) {
        throw 'Invalid path, expected an array or string by found ' + JSON.stringify(path);
    }
    if (path.length === 0) {
        return item;
    }
    const att = path.shift();
    return Object.evaluateRef(item[att], path);
}

// Exports the class
module.exports = ApiObject;
