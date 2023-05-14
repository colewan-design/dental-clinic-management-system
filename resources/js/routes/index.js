import Main from '../Pages/Main.vue'
import Login from '../Pages/Login.vue'
import Superadmin_Dashboard from '../Pages/Superadmin/Superadmin_Dashboard.vue'
import SuperAdmin_Profile from '../Pages/Superadmin/Superadmin_Dashboard.vue'
import Patients from '../Pages/Superadmin/Patients.vue'
import Clinic from '../Pages/Superadmin/Clinic.vue'
import Appointments from '../Pages/Superadmin/Appointments.vue'
import Database from '../Pages/Superadmin/Database.vue'
import Dentists from '../Pages/Superadmin/Dentists.vue'
import Sessions from '../Pages/Superadmin/Sessions.vue'
//Navigation
import SuperadminNavigation from '../Pages/Navigation/SuperadminNavigation.vue'


export default {
  mode: 'history',
    routes: [
        {
            path: '/',
            component: Login
        },
        {
            path: '/main',
            name: 'main',
            component: Main,
            meta: { requiresAuth: true }
        },
  
        {
            path: '/login',
            name: 'login',
            component: Login
        },
       
        {
            path: '/Superadmin_Dashboard',
            name: 'Superadmin_Dashboard',
            component: Superadmin_Dashboard,    
            meta: { requiresAuth: true }
        },
      
        {
          path: '/superadmin_profile',
          name: 'superadmin_profile',
          component: SuperAdmin_Profile,
          meta: { requiresAuth: true }
      },
      {
        path: '/patients',
        name: 'patients',
        component: Patients,
        meta: { requiresAuth: true }
    },

    {
      path: '/dentists',
      name: 'dentists',
      component: Dentists,
      meta: { requiresAuth: true }
  },
  {
    path: '/appointments',
    name: 'appointments',
    component: Appointments,
    meta: { requiresAuth: true }
},
{
  path: '/sessions',
  name: 'sessions',
  component: Sessions,
  meta: { requiresAuth: true }
},
{
  path: '/clinic',
  name: 'clinic',
  component: Clinic,
  meta: { requiresAuth: true }
},
{
  path: '/database',
  name: 'database',
  component: Database,
  meta: { requiresAuth: true }
},
      
       
    ],
    beforeEach: (to, from, next) => {
      if (to.meta.requiresAuth) {
        requireAuth(to, from, next)
      } else if (to.meta.guest) {
        if (localStorage.getItem('token')) {
          next('/dashboard')
        } else {
          next()
        }
      } else {
        next()
      }
    }
}
