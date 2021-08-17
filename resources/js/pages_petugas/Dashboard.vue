<template>
    <div class="container">
        <h1>Dashboard Petugas</h1>
        <p>Welcome&nbsp;{{user.nama}}</p>
    </div>
</template>

<script>
module.exports = {
    data:function(){
        return {
            user: [],
        }
    },
    methods: {
        auth: function(){
            if ($store.getters.authLevel != "petugas") {
                localStorage.removeItem("Authorization")
                this.$router.push({name:'LoginPetugas'});
            } else {
                return next()
            }
        },
        getData: function(id){
            let conf = {headers: {"Authorization" : 'Bearer' + this.key}};
            this.axios.get("/petugas/" + this.id, conf)
            .then(response => {
                if (response.data.success == true) {
                    this.$bvToast.hide("loadingToast");
                    this.user = response.data.data.user;
                    console.log(response)
                } else {
                    this.$bvToast.hide("loadingToast");
                    this.message = "Gagal menampilkan data masyarakat."
                    this.$bvToast.show("message");
                    console.log(response)
                }
            })
        }
    },
    mounted(){
        this.key = localStorage.getItem("Authorization");
        this.getData();
    }
}
</script>