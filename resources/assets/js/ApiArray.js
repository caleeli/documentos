function ApiArray(url, errorsObject) {
    var me = this;
    var self = new Array();
    var storage;
    self.loading = false;
    errorsObject = errorsObject === undefined ? {message: "", errors: []} : errorsObject;
    function cleanErrors() {
        Vue.set(errorsObject, 'message', "");
        Vue.set(errorsObject, 'errors', []);
    }
    this.listenStorage = (data) => {
        self.loading = false;
        self.splice(0);
        for (var row of data) {
            self.push(row);
        }
    };
    self.listenStorage = this.listenStorage;
    this.listenErrors = (error) => {
        for (var a in error) {
            Vue.set(errorsObject, a, error[a]);
        }
    };
    this.listenLoading = (loading) => {
        self.loading = loading;
    };
    self.listenLoading = this.listenLoading;
    self.loadFromAPI = function(newURL) {
        cleanErrors();
        if (newURL !== undefined) {
            storage ? storage.unregister(this) : null;
            storage = new ApiStorage(newURL, this);
            url = newURL;
        } else {
            storage ? storage.update() : null;
        }
        return this;
    };
    self.setPagingOptions = (page, per_page) => {
        const purl = new URL(url, document.location.href);
        purl.searchParams.set('page', page);
        purl.searchParams.set('per_page', per_page);
        self.loadFromAPI(purl.pathname + purl.search);
        return this;
    };
    self.setSearchParams = (params) => {
        const purl = new URL(url, document.location.href);
        Object.keys(params).forEach(key => {
            if (params[key] instanceof Array) {
                purl.searchParams.delete(key);
                params[key].forEach(value => purl.searchParams.append(key, value));
            } else {
                purl.searchParams.set(key, params[key]);
            }
        });
        self.loadFromAPI(purl.pathname + purl.search);
        return this;
    };
    storage = url ? new ApiStorage(url, this) : null;
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
    if (compare === undefined) {
        compare = String.findInText;
    }
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
    } else if (att === '*' && item instanceof Object) {
        for (let a in item) {
            if (!(item[a] instanceof Function) && compareBy(item[a], filter, value, compare)) {
                return true;
            }
        }
    } else if (item instanceof Object) {
        return compareBy(item[att], filter, value, compare);
    }
    return false;
}
String.findInText = function(text, search) {
    return String(text).localeIndexOf(search, 'en', {sensitivity: 'base'}) > -1;
}
String.findInHTML = function(text, search) {
    const element = window.document.createElement('i');
    element.innerHTML = text;
    return element.innerText.localeIndexOf(search, 'en', {sensitivity: 'base'}) > -1;
}

// Exports the class
module.exports = ApiArray;
