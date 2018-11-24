function ApiObject(url) {
    var self = this;
    self.loadFromAPI = function(newURL) {
        if (newURL !== undefined) {
            url = newURL;
        }
        var self = this;
        window.axios.get(url)
                .then(function(response) {
                    for (var attr in response.data.data) {
                        Vue.set(self, attr, response.data.data[attr]);
                    }
                    window.localStorage[url] = JSON.stringify(self);
                });
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
    //Load initial data from local storage
    var string = window.localStorage[url];
    if (string) {
        try {
            let data = JSON.parse(string);
            for (var attr in data) {
                Vue.set(self, attr, data[attr]);
            }
        } catch (e) {

        }
    }
    //Register to model-channel
    window.Echo
            .channel('model-channel')
            .listen('ModelEvent', (e) => {
                if (e.model === self.model) {
                    self.loadFromAPI();
                }
            });
    //Load data from API
    self.loadFromAPI();
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
module.exports = ApiObject;
