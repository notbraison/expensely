import axios from 'axios';
window.axios = axios;

// Fetch the CSRF token from the cookies
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.axios.defaults.withCredentials = true; // Important: Include credentials with requests
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';//Identifies Ajax requests. Helps the server distinguish between regular and Ajax requests.
window.axios.defaults.headers.common['X-XSRF-TOKEN'] = 'XSRF-TOKEN';//This is for CSRF protection. Typically, the value should be dynamically set to the actual CSRF token provided by your backend.
window.axios.defaults.headers.common['Accept'] = 'application/json';//Specifies the response format you expect from the server, in this case, JSON.
window.axios.defaults.headers.common['Content-Type'] = 'application/json';//Indicates the format of the request payload, which is JSON here.
