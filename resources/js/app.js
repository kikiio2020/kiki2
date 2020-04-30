/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import VueRouter from 'vue-router';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import PortalVue from 'portal-vue';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

import '@fortawesome/fontawesome-free/js/fontawesome';
import '@fortawesome/fontawesome-free/js/solid';
import '@fortawesome/fontawesome-free/js/regular';
import '@fortawesome/fontawesome-free/js/brands';

import Home from './components/Home.vue';
import About from './components/About.vue';
import Projects from './components/Projects.vue';

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(PortalVue);

const routes = [
	{ path: '/', component: Home},
	{ path: '/about', component: About},
	{ path: '/projects', component: Projects}
];

const router = new VueRouter({
	routes
});

const app = new Vue({
	el: '#app',
	router,
    data: {
    	menuOpened: false,
    	menuItems: {
    		about: {
    			url: '/about'
    		},
    		projects: {
    			url: '/projects'
    		}
    	},
    	externalMenuItems: {
    		'twitter': {
    			url: 'https://twitter.com/Kikiio2020',
    			icon:'fab fa-twitter',
    		},
    		'github': {
    			url: 'https://github.com/kikiio2020',
    			icon: 'fab fa-github',
    		},
    		/*'patreon': {
    			url: 'https://www.patreon.com/~kikiio2020',
    			icon: 'fab fa-patreon',
    		},*/
    		'email': {
    			url: 'mailto:info@kikiio.com',
    			icon: 'fas fa-envelope-square',
    		},
    	},
    	
    },
    computed: {
    },
    methods:{
    	goBack() {
    		window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/')
	    }
    },
    mounted() {
    }
});
