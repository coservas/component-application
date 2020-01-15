import 'babel-polyfill'
import Vue from 'vue'
import axios from 'axios'
import LoginForm from './components/login-form'
import RegisterForm from './components/register-form'

global.Vue = Vue
global.axios = axios

Vue.component('LoginForm', LoginForm)
Vue.component('RegisterForm', RegisterForm)
