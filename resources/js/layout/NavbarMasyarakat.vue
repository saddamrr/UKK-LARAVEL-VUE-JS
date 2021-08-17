<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand h2">Web Pengaduan Masyarakat</a>
            <div class="d-flex">
                <router-link :to="{name: 'LoginMasyarakat'}" class="nav-link justify-content-end">Login</router-link>
                <router-link :to="{name: 'Register'}" class="nav-link justify-content-end">Register</router-link>
            </div>
        </div>
    </nav>
</template>

<script>
export default {

}
</script>