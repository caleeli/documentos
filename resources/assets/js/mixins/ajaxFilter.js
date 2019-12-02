export default {
    methods: {
        updateFilter(array, search, filterBy, filter = []) {
            if (array.setSearchParams instanceof Function) {
                /*const value = JSON.stringify('%' + search + '%');
                const attributes = /\sattributes\.(\w+)/g;
                const relationships = /\srelationships\.(\w+).attributes\.(\w+)/g;
                let attr;
                while(attr = attributes.exec(' ' + filterBy)) {
                    filter.push(filter.length ? 'orWhere,' + attr[1] + ',ilike,' + value : 'where,' + attr[1] + ',ilike,' + value);
                }
                while(attr = relationships.exec(' ' + filterBy)) {
                    filter.push('@' + attr[1] + ',' + (filter.length ? 'orWhereHas,' + attr[2] + ',ilike,' + value : 'whereHas,' + attr[2] + ',ilike,' + value));
                }
                array.setSearchParams({'filter[]' : filter});*/
                const attributes = /\sattributes\.(\w+)/g;
                const relationships = /\srelationships\.(\w+).attributes\.(\w+)/g;
                let attr;
                const ajaxFilter = ['whereAjaxFilter', JSON.stringify(search)];
                while(attr = attributes.exec(' ' + filterBy)) {
                    ajaxFilter.push(attr[1]);
                }
                while(attr = relationships.exec(' ' + filterBy)) {
                    ajaxFilter.push('@' + attr[1] + '.' + attr[2]);
                }
                filter.push(ajaxFilter.join(','));
                array.setSearchParams({'filter[]' : filter});
            }
        },
    }
}
