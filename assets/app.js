import 'babel-polyfill'
import Vue from 'vue'
import axios from 'axios'
import LoginForm from './components/login-form'

global.Vue = Vue
global.axios = axios

Vue.component('LoginForm', LoginForm)
