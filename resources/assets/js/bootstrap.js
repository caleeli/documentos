
window._ = {
    get(object, dotPath) {
        dotPath ? dotPath.split('.').forEach(key => {
            object = object[key];
        }) : null;
        return object;
    }
};
window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * 
 * @param {string} name
 * @returns {string}
 */
function meta(name) {
    let tag = document.head.querySelector('meta[name="' + name + '"]');
    return tag ? tag.content : null;
}

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
let token = meta("csrf-token");
let api_token = meta("api-token");
window.logo = meta("logo");

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

if (api_token) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + api_token;
} else {
    console.error('API token not found');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import Echo from 'laravel-echo';

let broadcasterHost = meta("broadcaster-host");
if (broadcasterHost) {
    window.io = require('socket.io-client');

    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: meta("broadcaster-host"),
        key: meta("broadcaster-key")
    });

    window.Echo.channel('test-event')
            .listen('ExampleEvent', (e) => {
                console.log(e);
            });
    window.Echo.private('App.User.1')
            .listen('ExampleEvent', (e) => {
                console.log('private: ', e);
            });
}

// localeIndexOf find multilanguage strings
String.prototype.localeIndexOf = require('locale-index-of').prototypeLocaleIndexOf(Intl);
