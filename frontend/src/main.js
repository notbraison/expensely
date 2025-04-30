import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from '../src/router/router';
import {createPinia} from 'pinia'
import axios from'axios'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { register } from 'swiper/element/bundle';// import function to register Swiper custom elements
register();// register Swiper custom elements

axios.defaults.withCredentials = false
axios.defaults.withXSRFToken = false;
axios.defaults.headers.common['Accept'] = 'application/json'
axios.defaults.baseURL = 'http://localhost:8000' // Adjust if your API is on a different port


const app = createApp(App)
app.use(router);
app.component('VueDatePicker', VueDatePicker);
app.use(createPinia())
app.config.globalProperties.$axios = axios
app.mount('#app');