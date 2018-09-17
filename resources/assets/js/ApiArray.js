function ApiArray(url) {
    var self = new Array();
    //Since VueJS overwrite the array prototype, we don't use prototype
    //to add functions.
    //self.__proto__ = LocalData.prototype;
    self.url = url;
    self.loadFromAPI = function () {
        var self = this;
        window.axios.get(this.url)
                .then(function (response) {
                    self.splice(0);
                    for (var row of response.data.data) {
                        self.model = row.type;
                        self.push(row);
                    }
                    window.localStorage[self.url] = JSON.stringify(self);
                });
    };
    //Load initial data from local storage
    var string = window.localStorage[url];
    self.splice(0);
    if (string) {
        try {
            let data = JSON.parse(string);
            for (var row of data) {
                self.model = row.type;
                self.push(row);
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
module.exports = ApiArray;
