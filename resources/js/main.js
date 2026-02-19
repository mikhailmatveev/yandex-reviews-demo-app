import Vue from 'vue'
import VuePageTitle from 'vue-page-title'
import VueRouter from 'vue-router'
import router from './router'
import App from './App.vue'

Vue.use(VueRouter)

Vue.use(VuePageTitle, {
  suffix: '- yandex-reviews-demo-app',
  router
})

window.vue = new Vue({
  components: {
    Notification
  },
  router,
  render: h => h(App)
}).$mount('#app')
