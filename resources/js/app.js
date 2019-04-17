
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import moment from 'moment';
import Vue from 'vue'
import VueRouter from 'vue-router'
import VueProgressBar from 'vue-progressbar'
import swal from 'sweetalert2'
// import swal from 'sweetalert2/src/sweetalert2.js'


window.swal = swal;

const Toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.Toast = Toast;

window.BaseUrl= 'http://localhost:8000'


Vue.use(VueRouter)
Vue.use(VueProgressBar, options)

//load components
import Login_show from './components/login/login.vue';

// users selain admin
import Home from './components/users/home.vue';
import PermohonanCuti from './components/users/PermohonanCuti.vue';
import DataCuti from './components/users/dataCuti.vue';
import PermintaanCuti from './components/users/PermintaanCuti.vue';
import Read_detail from './components/users/ReadDetail.vue';
import Read_detail_saya from './components/users/ReadDetailKu.vue';


//mimin
import DataCutiAdminAll from './components/admins/dataCutiAll.vue';
import DataCutiAdminCetak from './components/admins/dataCutiCetak.vue';



import Print from './components/Print.vue';



Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const routes = [
    
    { path: '/', 
    //   component: Admin_home,
      components: {
        default: Home,
        login: Login_show,
        admin:Home,
        print: Print,
      },
      meta: {
        title: 'Dashboard - Cuti Online',
        metaTags: [
          {
            name: 'description',
            content: 'The home page of our example app.'
          },
          {
            property: 'og:description',
            content: 'The home page of our example app.'
          }
        ]
      }
    },
    { path: '/permohonan-cuti', 
    //   component: Admin_home,
      components: {
        default: PermohonanCuti,
        admin: Login_show
      },
      meta: {
        title: 'Dashboard - Cuti Online',
        metaTags: [
          {
            name: 'description',
            content: 'The home page of our example app.'
          },
          {
            property: 'og:description',
            content: 'The home page of our example app.'
          }
        ]
      }
    },
    { path: '/permintaan-cuti', 
    //   component: Admin_home,
      components: {
        default: PermintaanCuti,
        admin: Login_show
      },
      meta: {
        title: 'Dashboard - Cuti Online',
        metaTags: [
          {
            name: 'description',
            content: 'The home page of our example app.'
          },
          {
            property: 'og:description',
            content: 'The home page of our example app.'
          }
        ]
      }
    },
    { path: '/data-cuti', 
    //   component: Admin_home,
      components: {
        default: DataCuti,
        admin: Login_show
      },
      meta: {
        title: 'Dashboard - Cuti Online',
        metaTags: [
          {
            name: 'description',
            content: 'The home page of our example app.'
          },
          {
            property: 'og:description',
            content: 'The home page of our example app.'
          }
        ]
      }
    },
    { path: '/data-cuti-admin-all', 
    //   component: Admin_home,
      components: {
        default: Login_show,
        admin: DataCutiAdminAll
      },
      meta: {
        title: 'Dashboard - Cuti Online',
        metaTags: [
          {
            name: 'description',
            content: 'The home page of our example app.'
          },
          {
            property: 'og:description',
            content: 'The home page of our example app.'
          }
        ]
      }
    },
    { path: '/data-cuti-admin-cetak', 
    //   component: Admin_home,
      components: {
        default: Login_show,
        admin: DataCutiAdminCetak
      },
      meta: {
        title: 'Dashboard - Cuti Online',
        metaTags: [
          {
            name: 'description',
            content: 'The home page of our example app.'
          },
          {
            property: 'og:description',
            content: 'The home page of our example app.'
          }
        ]
      }
    },
    { path: '/detail-cuti/:id', component: Read_detail, name:'readPostDetail' },
    { path: '/detail-cutisaya/:id', component: Read_detail_saya, name:'readPostDetailSaya' },
    // { path: '*', 
    //   components: {
    //     default: Notfound,
    //     kasir: Notfound,
    //     pelanggan: Notfound
    //   },
    // // component: Notfound 
    // },
    
  ]

const options = {
  color: '#bffaf3',
  failedColor: '#874b4b',
  thickness: '15px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'left',
  inverse: false
}

Vue.filter('capitalize', function (value) {
  // if (!value) return ''
  // value = value.toString()
  // return value.charAt(0).toUpperCase() + value.slice(1)
  return value.toUpperCase()
});

Vue.filter('tanggali', function (value) {
  moment.locale('id'); 
  return moment(value).format('LLLL');
});

Vue.filter('yanglalu', function (value) {
  moment.locale('id'); 
  return moment(value).startOf('hour').fromNow(); 
});

Vue.filter('tanggal', function (value) {
  moment.locale('id'); 
  return moment(value).format('dddd, Do MMMM  YYYY');
});

Vue.filter('tgldoang', function (value) {
  moment.locale('id'); 
  return moment(value).format('dddd, Do MMMM  YYYY');
});



const router = new VueRouter({
// mode: 'history',

routes, // short for `routes: routes`
linkActiveClass: 'active'
})

  
const app = new Vue({
    router
  }).$mount('#app')
  
