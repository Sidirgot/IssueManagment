window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Intercept the request and redirect to login screen
 * if unauthenticated.
 * 
 */
axios.interceptors.response.use((response) => {
    return response

}, ((error) => {
    
    if (error.response.status === 401) {
        location.replace('/login')
    } 

}))

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
});
