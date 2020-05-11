function ApiStorage(url, object) {
    if (ApiStorage.instances[url]) {
        var storage = ApiStorage.instances[url];
        storage.register(object);
        storage.update();
        return storage;
    } else {
        ApiStorage.instances[url] = this;
    }
    var observers = [];
    var type;
    this.update = function() {
        notifyLoading(true);
        const url2 = url + (url.match(/\?/) ? '&' : '?') + 'timestamp=' + new Date().getTime() ;
        window.axios.get(url2)
                .then(response => {
                    notifyLoading(false);
                    type = response.data.meta.type;
                    dispatch(response.data.data, response.data.meta);
                })
                .catch(error => {
                    notifyLoading(false);
                    notifyErrors(error.response.data);
                });
    }
    function dispatch(data, meta) {
        observers.forEach((item) => {
            item.listenStorage(data, meta);
        });
        // Store
        //window.localStorage[url] = JSON.stringify({data, meta});
    }
    function notifyErrors(errors) {
        observers.forEach((item) => {
            item.listenErrors(errors);
        });
    }
    function notifyLoading(value) {
        observers.forEach((item) => {
            item.listenLoading(value);
        });
    }
    this.register = function(item) {
        observers.push(item);
        // Load from local storage
        /*try {
            var string = window.localStorage[url];
            var json = JSON.parse(string);
            string ? item.listenStorage(json.data, json.meta) : null;
        } catch (e) {
            console.log(e);
        }*/
    }
    this.unregister = function(item) {
        var index = observers.indexOf(item);
        index > -1 ? observers.splice(index, 1) : null;
    }
    // Register to model-channel
    if (window.Echo) {
        window.Echo
            .channel('model-channel')
            .listen('ModelEvent', (e) => {
                if (e.model === type) {
                    this.update();
                }
            });
    }
    // Initialize
    this.register(object);
    this.update();
}
ApiStorage.instances = {};

// Exports the class
module.exports = ApiStorage;
