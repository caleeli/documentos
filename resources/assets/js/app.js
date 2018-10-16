
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./components/children2string');
import moment from 'moment';
import VueRouter from 'vue-router';

window.Vue = require('vue');
window.ApiArray = require('./ApiArray');
window.ApiObject = require('./ApiObject');
window.Vue.prototype.window = window;
window.Vue.prototype.moment = moment;
moment.locale('es');
window.Vue.prototype.dateFormat = function (date){
    return moment(date).format('DD/MM/YYYY HH:mm');
};
window.moment = moment;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('panel', require('./components/Panel.vue'));
Vue.component('actions', require('./components/Actions.vue'));
Vue.component('tree', require('./components/Tree.vue'));
Vue.component('vnode', require('./components/Vnode.vue'));
Vue.component('notification', require('./components/Notification.vue'));
Vue.component('SelectBox', require('./components/SelectBox.vue'));
Vue.component('date-time', require('./components/DateTime'));
Vue.component('grid', require('./components/Grid'));
Vue.component('document', require('./components/Document'));
Vue.component('avatar', require('./components/Avatar'));


/**
 * MODULOS
 */
const routes = [];
const req = require.context('./modules/', true, /\.(js|vue)$/i);
req.keys().map(key => {
    const name = key.match(/\w+/)[0];
    const component = Vue.component(name, req(key));
    routes.push({path: '/' + name, component: component});
    return component;
});

const router = new VueRouter({
  routes
});

window.Vue.use(VueRouter);
const app = new Vue({
    router,
    el: '#app',
    data() {
        return {
            topbar: {
                notification: {
                    countClass: '',
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
            logo128: '/images/logo128.png',
            logo: '/images/logo.png'//'http://subcep.com/images/logo2.png'
        };
    },
    methods: {
        gridEdit(a,b,c){
            console.log(a,b,c);
        }
    }
});

window.app = app;
