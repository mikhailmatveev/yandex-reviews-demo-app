import VueRouter from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Reviews',
    component: () => import(/* webpackChunkName: "home" */ '../views/Reviews.vue'),
    meta: {
      title: 'Отзывы'
    }
  }, {
    path: '/settings',
    name: 'Settings',
    component: () => import(/* webpackChunkName: "home" */ '../views/Settings.vue'),
    meta: {
      title: 'Настройки'
    }
  }
]

export default new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
  linkActiveClass: 'active'
})
