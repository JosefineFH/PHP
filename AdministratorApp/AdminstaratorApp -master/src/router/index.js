import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import Department from '@/components/Department'
import User from '@/components/User'
import Modal from '@/components/Modal'
import NewUser from '@/components/NewUser'
import Application from '@/components/Application'
import Axios from 'axios'


Vue.use(Router)

export default new Router({

  routes: [
    {
      path: '/',
      name: 'Login',
      component: Login
    },
    {
      path: '/Department',
      name: 'Department',
      component: Department,
      props: true
    },
    {
      path: '/User',
      name: 'User',
      component: User,
      props: true
    },
    {
      path: '/Modal',
      name: 'Modal',
      component: Modal,
      props: true
    },
    {
      path: '/NewUser',
      name: 'NewUser',
      component: NewUser,
      props: true
    },
    {
      path: '/Application',
      name: 'Application',
      component: Application,
      props: true
    }


  ]
})
