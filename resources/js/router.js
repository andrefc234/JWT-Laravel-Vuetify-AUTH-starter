// router.js

import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/Pages/Home.vue'
import Login from '@/Pages/Login.vue'

const routes = [
  { path: '/', component: Home },
  { path: '/login', component: Login }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
