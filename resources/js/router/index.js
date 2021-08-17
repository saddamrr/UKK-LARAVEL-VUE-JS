import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'
Vue.use(VueRouter)

import NavbarAdmin from '../layout/NavbarAdmin.vue'
import NavbarMasyarakat from '../layout/NavbarMasyarakat.vue'
import NavbarDashboardMasyarakat from '../layout/NavbarDashboardMasyarakat.vue'
import NavbarDashboardPetugas from '../layout/NavbarDashboardPetugas.vue'
import Footer from '../layout/Footer.vue'

import LoginAdmin from '../pages_admin/Login.vue'
import DashboardAdmin from '../pages_admin/Dashboard.vue'
import TabelMasyarakat from'../pages_admin/TabelMasyarakat.vue'
import TabelPetugas from '../pages_admin/TabelPetugas.vue'
import UbahStatusAdmin from '../pages_admin/UbahStatus.vue'
import TanggapanAdmin from '../pages_admin/Tanggapan.vue'
import Laporan from '../pages_admin/Laporan.vue'

import LoginMasyarakat from '../pages_masyarakat/Login.vue'
import RegisterMasyarakat from '../pages_masyarakat/Register.vue'
import DashboardMasyarakat from '../pages_masyarakat/Dashboard.vue'
import BuatPengaduan from '../pages_masyarakat/BuatPengaduan.vue'

import LoginPetugas from '../pages_petugas/Login.vue'
import DashboardPetugas from '../pages_petugas/Dashboard.vue'
import UbahStatusPetugas from '../pages_petugas/UbahStatus.vue'
import TanggapanPetugas from '../pages_petugas/Tanggapan.vue'

import NotFound from '../not_found/NotFound.vue'

const routes = [
    {
        name: 'LoginAdmin',
        path: '/login/admin',
        component: LoginAdmin
    },
    {
        name: 'DashboardAdmin',
        path: '/dashboard/admin',
        components: {default: DashboardAdmin, header: NavbarAdmin, footer: Footer},
        meta: { 
            requiresAuth: true
        }
    },
    {
        name: 'TabelMasyarakat',
        path: '/dashboard/admin/manage_masyarakat',
        components: {default: TabelMasyarakat, header: NavbarAdmin, footer: Footer},
        meta: { 
            requiresAuth: true
        }
    },
    {
        name: 'TabelPetugas',
        path: '/dashboard/admin/manage_petugas',
        components: {default: TabelPetugas, header: NavbarAdmin, footer: Footer},
        meta: { 
            requiresAuth: true
        }
    },
    {
        name: 'TanggapiByAdmin',
        path: '/dashboard/admin/tanggapi_pengaduan',
        components: {default: TanggapanAdmin, header: NavbarAdmin, footer: Footer},
        meta: { 
            requiresAuth: true
        }
    },
    {
        name: 'UbahStatusAdmin',
        path: '/dashboard/admin/ubah_status',
        components: {default: UbahStatusAdmin, header: NavbarAdmin, footer: Footer},
        meta: { 
            requiresAuth: true
        }
    },
    {
        name: 'Laporan',
        path: '/dashboard/admin/report',
        components: {default: Laporan, header: NavbarAdmin, footer: Footer},
        meta: { 
            requiresAuth: true
        }
    },
    {
        name: 'LoginMasyarakat',
        path: '/login',
        components: {default: LoginMasyarakat, header: NavbarMasyarakat, footer: Footer},
    },
    {
        name: 'Register',
        path: '/register',
        components: {default: RegisterMasyarakat, header: NavbarMasyarakat, footer: Footer},
    },
    {
        name: 'DashboardMasyarakat',
        path: '/dashboard/pengaduan_masyarakat',
        components: {default: DashboardMasyarakat, header: NavbarDashboardMasyarakat, footer: Footer},
        meta: { 
            requiresAuthMasyarakat: true
        }
    },
    {
        name: 'BuatPengaduan',
        path: '/dashboard/pengaduan_masyarakat/buat_pengaduan',
        components: {default: BuatPengaduan, header: NavbarDashboardMasyarakat, footer: Footer},
        meta: { 
            requiresAuthMasyarakat: true
        }
    },
    {
        name: 'LoginPetugas',
        path: '/login/petugas',
        component: LoginPetugas
    },
    {
        name: 'DashboardPetugas',
        path: '/dashboard/petugas',
        components: {default: DashboardPetugas, header: NavbarDashboardPetugas, footer: Footer},
        meta: { 
            requiresAuthPetugas: true
        }
    },
    {
        name: 'TanggapiByPetugas',
        path: '/dashboard/petugas/tanggapi_pengaduan',
        components: {default: TanggapanPetugas, header: NavbarDashboardPetugas, footer: Footer},
        meta: { 
            requiresAuthPetugas: true
        }
    },
    {
        name: 'UbahStatusPetugas',
        path: '/dashboard/petugas/ubah_status',
        components: {default: UbahStatusPetugas, header: NavbarDashboardPetugas, footer: Footer},
        meta: { 
            requiresAuthPetugas: true
        }
    },
    {
        path: '/*',
        component: NotFound
    }
]

const router = new VueRouter({
    base: process.env.BASE_URL,
    linkActiveClass: true,
    mode: 'history',
    routes
})

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
      if (store.getters.authStatus == "success") {
        next()
        return
      }
      next('/login/admin')
    } else {
        next()
    }
});

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuthMasyarakat)) {
      if (store.getters.authStatus == "success") {
        next()
        return
      }
      next('/login')
    } else {
        next()
    }
})

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuthPetugas)) {
      if (store.getters.authStatus == "success") {
        next()
        return
      }
      next('/login/petugas')
    } else {
        next()
    }
})

export default router