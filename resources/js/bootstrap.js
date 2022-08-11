// window._ = require('lodash');

try {
    require('bootstrap');
    window.$ = window.jQuery = require('../../public/vendor/jquery/jquery.min');
    // window.Popper = require('popper');
    require('../../public/vendor/bootstrap/js/bootstrap.bundle');
    require('../../public/vendor/overlayScrollbars/js/jquery.overlayScrollbars.min');
    window.toastr = require('../../public/vendor/toastr/toastr.min.js');
    window.bsCustomFileInput = require('../../public/vendor/bs-custom-file-input/bs-custom-file-input.min');
    require('../../public/vendor/adminlte/dist/js/adminlte.min.js');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
