import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import Notifications from 'vue-notification'

Vue.use(Notifications)

import 'bootstrap';
import "@/assets/bootstrap.css";
import "font-awesome/css/font-awesome.min.css";
import "@/assets/custom.css";

require('@/store/subscriber')

axios.defaults.baseURL = process.env.VUE_APP_API_BASE_URL;

Vue.config.productionTip = false

store.dispatch('auth/attempt', localStorage.getItem('token')).then(() => {
  new Vue({
    router,
    store,
    render: h => h(App)
  }).$mount('#app')
});
