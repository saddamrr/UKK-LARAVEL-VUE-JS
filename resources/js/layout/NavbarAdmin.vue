<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand h2">Admin Page</a>
            <div class="d-flex">
                <router-link :to="{name: 'DashboardAdmin'}" class="nav-link justify-content-end">Dashboard</router-link>
                <router-link :to="{name: 'TabelMasyarakat'}" class="nav-link justify-content-end">Tabel Masyarakat</router-link>
                <router-link :to="{name: 'TabelPetugas'}" class="nav-link justify-content-end">Tabel Petugas</router-link>
                <router-link :to="{name: 'TanggapiByAdmin'}" class="nav-link justify-content-end">Tanggapan</router-link>
                <router-link :to="{name: 'UbahStatusAdmin'}" class="nav-link justify-content-end">Ubah Status</router-link>
                <router-link :to="{name: 'Laporan'}" class="nav-link justify-content-end">Laporan</router-link>
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
          this.axios.post('/logout', form, conf).then(response => {
            if (response.data.success == true) {
                // this.$store.commit('logout')
                // localStorage.removeItem("Authorization")
                this.$router.push({name: 'LoginAdmin'})
                console.log(response)
            }
          }).catch(error => {
              console.log(error)
        });
      },
    },
}
</script>