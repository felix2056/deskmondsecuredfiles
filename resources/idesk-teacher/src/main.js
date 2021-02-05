import Vue from 'vue'
import App from './App.vue'
import router from './router/router'

import VueAxios from "vue-axios";
import axios from "axios";
//import { setup } from "axios-cache-adapter";

Vue.use(VueAxios, axios);
axios.defaults.headers.common = {
  "X-Requested-With": "XMLHttpRequest",
  "Accept": "application/json",
  "Content-Type": "application/x-www-form-urlencoded",
  "X-CSRF-TOKEN": document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute("content")
};

// Create `axios` instance with pre-configured `axios-cache-adapter` attached to it
//const axios_cache = setup({
  // `axios-cache-adapter` options
  // cache: {
  //     maxAge: 15 * 60 * 1000
  // }
//});

//window.axios_cache = axios_cache;

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import FlashMessage from '@smartweb/vue-flash-message'
import VueQuillEditor from 'vue-quill-editor'
import VueTimeago from 'vue-timeago';

import 'material-design-iconic-font/dist/css/material-design-iconic-font.min.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import './assets/css/my-css.css'
import './assets/css/vars.css'
import './assets/css/annotator.min.css'
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

require('../../js/bootstrap')

Vue.use(VueQuillEditor)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(FlashMessage);
Vue.use(VueTimeago, {
  name: 'timeago', // component name, `timeago` by default
  locale: 'en-US',
  /*locales: {
      'en-US': require('vue-timeago/locales/en-US.json')
  }*/ 
});

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
