import Vue from 'vue'
import App from './App.vue'
import router from './router/router'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VueFlashMessage from 'vue-flash-message'
import VueQuillEditor from 'vue-quill-editor'
import moment from 'moment'

import 'material-design-iconic-font/dist/css/material-design-iconic-font.min.css'
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import './assets/css/my-css.css'
import './assets/css/vars.css'

require('../../js/bootstrap')

window.moment = moment

Vue.use(VueQuillEditor)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueFlashMessage)

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
