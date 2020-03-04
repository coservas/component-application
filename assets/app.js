import 'babel-polyfill'
import Vue from 'vue'
import axios from 'axios'
import Login from './components/login'
import Register from './components/register'
import Profile from './components/profile/profile'

global.Vue = Vue
global.axios = axios

Vue.component('Login', Login)
Vue.component('Register', Register)
Vue.component('Profile', Profile)
