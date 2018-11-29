function ApiStorage(url, object) {
    if (ApiStorage.instances[url]) {
        var storage = ApiStorage.instances[url];
        storage.register(object);
        return storage;
    } else {
        ApiStorage.instances[url] = this;
    }
    var observers = [];
    var type;
    this.update = function() {
        window.axios.get(url)
                .then(function(response) {
                    type = response.data.meta.type;
                    dispatch(response.data.data);
                });
    }
    function dispatch(data) {
        observers.forEach((item) => {
            item.listenStorage(data);
        });
        // Store
        window.localStorage[url] = JSON.stringify(data);
    }
    this.register = function(item) {
        observers.push(item);
        // Load from local storage
        try {
            var string = window.localStorage[url];
            string ? item.listenStorage(JSON.parse(string)) : null;
        } catch (e) {
            console.log(e);
        }
    }
    this.unregister = function(item) {
        var index = observers.indexOf(item);
        index > -1 ? observers.splice(index, 1) : null;
    }
    // Register to model-channel
    window.Echo
            .channel('model-channel')
            .listen('ModelEvent', (e) => {
                if (e.model === type) {
                    this.update();
                }
            });
    // Initialize
    this.register(object);
    this.update();
}
ApiStorage.instances = {};

// Exports the class
module.exports = ApiStorage;
