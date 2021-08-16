import VueRouter from 'vue-router'
// Pages
import Home from './pages/Home'
import Register from './pages/Register'
import Login from './pages/Login'
import Dashboard from './pages/user/Dashboard'
import AdminDashboard from './pages/admin/Dashboard'
import AdminEmployee from './pages/admin/Employee'

const routesWithPrefix = (prefix, meta, routes) => {
  return routes.map(route => {
    route.path = `${prefix}${route.path}`
    route.meta = meta;
    return route
  })
}

// Routes
const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
    meta: {
      auth: undefined
    }
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: {
      auth: false
    }
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      auth: false
    }
  },

  // USER ROUTES
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta: {
      auth: true
    }
  },

  // ADMIN ROUTES
  ...routesWithPrefix('/admin', { auth: { roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/403' } }, [
    {
      path: '/',
      name: 'admin.dashboard',
      component: AdminDashboard 
    },
    {
      path: '/employee',
      name: 'admin.employee',
      component: AdminEmployee,
    }
  ])
]

const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})

export default router