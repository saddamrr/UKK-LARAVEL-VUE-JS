<template>
    <div class="container">
        <h1>Dashboard Admin</h1>
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
            if ($store.getters.authLevel != "admin") {
                localStorage.removeItem("Authorization")
                this.$router.push({name:'LoginAdmin'});
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
                    this.message = "Gagal menampilkan data."
                    this.$bvToast.show("message");
                    console.log(response)
                    this.$router.push({name: "LoginAdmin"})
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