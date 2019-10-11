
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./components/children2string');
import moment from 'moment';
import VueRouter from 'vue-router';
import TaskMixin from './mixins/task.js';
import Vue from 'vue';
import Vuex from 'vuex';
import BootstrapVueTreeview from 'bootstrap-vue-treeview';

/**
 * Get meta tag value
 * @param {string} name
 * @returns {string}
 */
function meta(name) {
    let tag = document.head.querySelector('meta[name="' + name + '"]');
    return tag ? tag.content : null;
}
window.userId = meta('user-id') * 1;

// Configure Vue
Vue.prototype.window = window;
Vue.prototype.moment = moment;
Vue.prototype.colLabel = 'col-lg-2 col-md-4 col-sm-12 col-xs-12 text-md-right';
Vue.prototype.colField = 'col-lg-10 col-md-8 col-sm-12 col-xs-12';
Vue.prototype.colField2 = 'col-lg-5 col-md-4 col-sm-6 col-xs-12';
Vue.prototype.dateFormat = function(date) {
    return moment(date).format('DD/MM/YYYY HH:mm');
};
Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(BootstrapVueTreeview);

// Configure global javascript objects
window.Vue = Vue;
window.Vuex = Vuex;
window.ApiStorage = require('./ApiStorage');
window.ApiArray = require('./ApiArray');
window.ApiObject = require('./ApiObject');
moment.locale('es');
window.moment = moment;
window.taskMixin = TaskMixin;

/**
 * COMPONENTES
 */
const com = require.context('./components/', true, /\.(vue)$/i);
com.keys().map(key => {
    const name = key.match(/\w+/)[0];
    const component = Vue.component(name, com(key));
    return component;
});


/**
 * MODULOS
 */
const routes = [];
const req = require.context('./modules/', true, /\.(js|vue)$/i);
req.keys().map(key => {
    const def = req(key);
    const name = key.match(/\w+/)[0];
    const component = Vue.component(name, def);
    routes.push({path: def.path ? def.path : '/' + name, component: component});
    return component;
});

/**
 * Create Vue Application and register routes
 */
const router = new VueRouter({
    routes
});
window.router = router;

const app = new Vue({
    router,
    el: '#app',
    data() {
        return {
            user: new ApiObject('/api/users/' + window.userId),
            notifications: [],
            topbar: {
                notification: {
                    countClass: 'text-primary',
                    notificaciones: []
                }
            },
            menu: {
                class: 'panel-primary',
                icon: '',
                name: 'Menu principal',
                actionClass: 'btn btn-inline btn-outline-secondary btn-sm',
                direction: 'vertical',
                actions: {
                    collapse: {name: '', icon: 'fas fa-minus', iconActive: 'fas fa-plus', active: false}
                }
            },
            tree: {
                name: '',
                children: [
                    {
                        icon: 'fas fa-copy',
                        name: 'Lista de documentos',
                        $collapsed: false,
                        actions: {
                            open: {name: '', icon: 'fas fa-greater-than', href: '/ListaDocumentos'}
                        },
                        children: [
                        ]
                    },
                    {
                        icon: 'fas fa-envelope',
                        name: 'Remisión de información',
                        $collapsed: false,
                        actions: {
                            open: {name: '', icon: 'fas fa-greater-than', href: '/RemisionDocumentos'}
                        },
                    },
                ]
            },
            logo128: '/images/logo-banner.svg',
            logo: '/images/logo.png'//'http://subcep.com/images/logo2.png'
        };
    },
    methods: {
        gridEdit(a, b, c) {
            console.log(a, b, c);
        }
    }
});

window.app = app;
