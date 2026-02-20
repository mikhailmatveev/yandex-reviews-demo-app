import Vue from 'vue'
import VuePageTitle from 'vue-page-title'
import VueRouter from 'vue-router'
import router from './router'
import App from './App.vue'
import dotenv from 'dotenv'

import 'source-sans-pro/source-sans-pro.css'
import '../css/style.scss'

Vue.use(VueRouter)

Vue.use(VuePageTitle, {
  suffix: '- yandex-reviews-demo-app',
  router
})

// Переменные из .env
dotenv.config()

new Vue({
  components: {
    Notification
  },
  router,
  render: h => h(App)
}).$mount('#app')
