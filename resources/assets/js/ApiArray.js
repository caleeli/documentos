function ApiArray(url) {
    var self = new Array();
    //Since VueJS overwrite the array prototype, we don't use prototype
    //to add functions.
    //self.__proto__ = LocalData.prototype;
    self.url = url;
    self.loadFromAPI = function() {
        var self = this;
        window.axios.get(this.url)
                .then(function(response) {
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
Array.prototype.filterBy = function(filters, text, compare)
{
    return this.filter(row => {
        if (!text) {
            return true;
        }
        for (let i = 0, l = filters.length; i < l; i++) {
            var filter = typeof filters[i] === "string" ? filters[i].trim() : false;
            if (filter && compareBy(row, filter.split('.'), text, compare)) {
                return true;
            }
        }
        return false;
    });
}
function compareBy(item, filter, value, compare) {
    if (filter.length === 0) {
        return compare(item, value);
    }
    const att = filter.shift();
    if (att === '*' && item instanceof Array) {
        for (let i = 0, l = item.length; i < l; i++) {
            if (compareBy(item[i], filter, value, compare)) {
                return true;
            }

        }
    } else if (att === '*') {
        for (let a in item) {
            if (!(item[a] instanceof Function) && compareBy(item[a], filter, value, compare)) {
                return true;
            }
        }
    } else {
        return compareBy(item[att], filter, value, compare);
    }
    return false;
}
module.exports = ApiArray;
