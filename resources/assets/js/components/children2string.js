window.children2string = function (children, div) {
    if (div === undefined) {
        div = window.document.createElement('div');
    }
    children.map(function (node) {
        const dom = window.node2dom(node);
        div.appendChild(dom);
    });
    return div.innerHTML;
};
window.node2string = function (node, rename) {
    const div = window.document.createElement('div');
    const dom = window.node2dom(node, rename);
    div.appendChild(dom);
    return div.innerHTML;
};
function setAttribute(dom, name, value) {
    if (value instanceof Object && name.substr(0, 7) !== 'v-bind:') {
        dom.setAttribute('v-bind:' + name, window.vnoderef(value));
    } else if (value instanceof Object && name.substr(0, 7) === 'v-bind:') {
        dom.setAttribute(name, JSON.stringify(value));
    } else {
        dom.setAttribute(name, value);
    }

}
window.node2dom = function (node, rename) {
    const tagName = rename ? rename : (node.tag && (ma=node.tag.match(/vue-component-\d+-(.+)/)) ? ma[1] : node.tag);
    const dom = tagName ? window.document.createElement(tagName) :
            window.document.createTextNode(node.text.split('{').join('{{').split('}').join('}}'));
    if (node.data) {
        for (var a in node.data.attrs) {
            let name = a.substr(0, 1) === '#'
                    ? ('v-on:' + a.substr(1))
                    : (a.substr(0, 1) === '$' ? 'v-bind:' + a.substr(1) : a);
            setAttribute(dom, name, node.data.attrs[a]);
        }
        if (node.data.staticClass) {
            setAttribute(dom, 'class', node.data.staticClass);
        }
        if (node.data.staticStyle) {
            let style = [];
            for (var s in node.data.staticStyle) {
                style.push(s + ':' + node.data.staticStyle[s]);
            }
            dom.setAttribute('style', style.join(';'));
        }
    }
    if (node.componentOptions) {
        for (var a in node.componentOptions.propsData) {
            let name = a.substr(0, 1) === '$' ? 'v-bind:' + a.substr(1) : a;
            name = name.replace(/[A-Z]/g, function (e) {
                return "-" + e.toLowerCase();
            });
            setAttribute(dom, name, node.componentOptions.propsData[a]);
        }
    }
    if (node.children) {
        node.children.forEach(function (node) {
            dom.appendChild(node2dom(node));
        });
    }
    return dom;
};
window.vnoderef = function (object) {
    let index = window.vnoderef.refs.indexOf(object);
    if (index === -1) {
        index = window.vnoderef.refs.length;
        window.vnoderef.refs.push(object);
    }
    return 'window.vnoderef.refs[' + index + ']';
}
window.vnoderef.refs = [];
