import Vue from 'vue'
import Router from 'vue-router'
import login from './components/login.vue'
import index from './components/index.vue'
//import About from './views/About.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/login',
      name: 'login',
      component: login
    },
    {
      path: '/',
      name: 'index',
      component: index
    }
  ]
})
