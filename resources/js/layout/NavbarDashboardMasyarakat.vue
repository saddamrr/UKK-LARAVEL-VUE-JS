<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand h2">Web Pengaduan Masyarakat</a>
            <div class="d-flex">
                <router-link :to="{name: 'DashboardMasyarakat'}" class="nav-link justify-content-end">Dashboard</router-link>
                <router-link :to="{name: 'BuatPengaduan'}" class="nav-link justify-content-end">Buat Pengaduan</router-link>
                <a href="" v-if="isLoggedIn" @click="logout" class="nav-link justify-content-end">Logout</a>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    computed : {
        isLoggedIn : function(){ return this.$store.getters.isLoggedIn}
    },
    methods:{
      logout:function(){
          let conf = { headers : {"Authorization" : "Bearer " + localStorage.getItem("Authorization")} };
          let form = new FormData();
          this.axios.post('/logout', conf).then(response => {
            if (response.data.success == true) {
                this.$store.commit('logout')
                localStorage.removeItem("Authorization")
                this.$router.push({name: 'LoginMasyarakat'})
            }
          }).catch(error => {
              console.log(response)
        });
      },
    },
}
</script>