export default {
    methods: {
        updateFilter(array, search, filterBy) {
            if (array.setSearchParams instanceof Function) {
                const filter = [];
                const value = JSON.stringify('%' + search + '%');
                const attributes = /\sattributes\.(\w+)/g;
                const relationships = /\srelationships\.(\w+).attributes\.(\w+)/g;
                let attr;
                while(attr = attributes.exec(' ' + filterBy)) {
                    filter.push(filter.length ? 'orWhere,' + attr[1] + ',ilike,' + value : 'where,' + attr[1] + ',ilike,' + value);
                }
                while(attr = relationships.exec(' ' + filterBy)) {
                    filter.push('@' + attr[1] + ',' + (filter.length ? 'orWhereHas,' + attr[2] + ',ilike,' + value : 'whereHas,' + attr[2] + ',ilike,' + value));
                }
                array.setSearchParams({'filter[]' : filter});
            }
        },
    }
}
