function ApiObject(url, errorsObject) {
    var storage;
    var self = this;
    errorsObject = errorsObject === undefined ? {} : errorsObject;
    function cleanErrors() {
        Object.keys(errorsObject).forEach(key => {
            delete errorsObject[key];
        });
    }
    this.listenStorage = (data) => {
        for (var attr in data) {
            Vue.set(self, attr, data[attr]);
        }
    };
    this.listenErrors = (errors) => {
        for(var a in errors) {
            Vue.set(errorsObject, a, errors[a]);
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
            error.response.data.message;
            this.listenErrors(error.response.data.errors);
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
            error.response.data.message;
            this.listenErrors(error.response.data.errors);
        });
    };
    storage = new ApiStorage(url, this);
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
