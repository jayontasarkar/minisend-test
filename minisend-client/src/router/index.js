import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import SignIn from '../views/SignIn.vue'
import SignUp from '../views/SignUp.vue'
import Dashboard from '../views/Dashboard.vue'
import Email from '../views/Email.vue'
import Recipient from '../views/Recipient.vue'
import Activity from '../views/Activity.vue'
import ApiToken from '../views/ApiToken.vue'
import store from '@/store'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/signin',
    name: 'signin',
    component: SignIn
  },
  {
    path: '/signup',
    name: 'signup',
    component: SignUp
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/emails/:id',
    name: 'emails',
    component: Email,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/recipients/:email',
    name: 'recipient',
    component: Recipient,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/activity',
    name: 'activity',
    component: Activity,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/tokens',
    name: 'tokens',
    component: ApiToken,
    meta: {
      requiresAuth: true
    }
  }
]

const router = new VueRouter({
  mode: 'history',
  linkExactActiveClass: 'is-active',
  routes
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.getters['auth/authenticated']) {
    return next({
      name: 'signin'
    })
  }

  next()
});

export default router
