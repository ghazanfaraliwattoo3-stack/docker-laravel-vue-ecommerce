
import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'
import router from './router.js'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'vue3-toastify/dist/index.css';
import store from './store/index.js';
import Toast from "vue3-toastify";
import ExampleComponent from './components/ExampleComponent.vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import '../css/app.css';

const app = createApp(App);
app.component('example-component', ExampleComponent);
app.use(Toast, {
    autoClose: 5000,  
});
app.use(store);
app.use(VueSweetalert2);
app.use(router);
app.mount('#app');
