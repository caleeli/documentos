function ApiObject(url) {
    var storage;
    var self = this;
    this.listenStorage = (data) => {
        for (var attr in data) {
            Vue.set(self, attr, data[attr]);
        }
    };
    self.loadFromAPI = function(newURL) {
        if (newURL !== undefined) {
            storage.unregister(this);
            storage = new ApiStorage(newURL, this);
        } else {
            storage.update();
        }
    };
    self.postToAPI = function(url) {
        var attributes = Object.assign({}, this.attributes);
        delete attributes.id;
        console.log({
            data: {
                type: this.type,
                attributes: attributes
            }
        });
        return window.axios.post(url, {
            data: {
                type: this.type,
                attributes: attributes
            }
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
