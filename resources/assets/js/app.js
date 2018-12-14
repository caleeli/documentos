
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./components/children2string');
String.prototype.localeIndexOf = require('locale-index-of').prototypeLocaleIndexOf(Intl);
import moment from 'moment';
import VueRouter from 'vue-router';

window.Vue = require('vue');
window.ApiStorage = require('./ApiStorage');
window.ApiArray = require('./ApiArray');
window.ApiObject = require('./ApiObject');
window.Vue.prototype.window = window;
window.Vue.prototype.moment = moment;
window.Vue.prototype.colLabel = 'col-lg-2 col-md-4 col-sm-12 col-xs-12 text-md-right';
window.Vue.prototype.colField = 'col-lg-10 col-md-8 col-sm-12 col-xs-12';
window.Vue.prototype.colField2 = 'col-lg-5 col-md-4 col-sm-6 col-xs-12';
moment.locale('es');
window.Vue.prototype.dateFormat = function(date) {
    return moment(date).format('DD/MM/YYYY HH:mm');
};
window.moment = moment;

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

const router = new VueRouter({
    routes
});

window.Process = {
    completeTask(params) {
        axios.get('/api/revision_carpetas/complete_task', {
            params: params
        }).then(() => {
            router.push({path: '/'});
            window.location.reload();
        });
    }
};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.Vue.use(VueRouter);
const app = new Vue({
    router,
    el: '#app',
    data() {
        return {
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
            logo128: '/images/logo128.png',
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
