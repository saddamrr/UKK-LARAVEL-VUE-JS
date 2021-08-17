<template>
  <div>
    <div class="container mt-3">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <p class="card-title float-left"><b>Data Pengaduan</b></p>
            
              <div class="table-responsive">
                <div class="dropdown-divider"></div>
                <b-table striped hover :items="data_pengaduan" :fields="fields">
                  <template v-slot:cell(foto)>
                    <img src="'/img/items' + foto" width="100px" alt="">
                  </template>
                </b-table>

                <b-toast id="loadingToast" title="Processing Data" no-auto-hide>
                  <b-spinner label="Spinning" variant="success"></b-spinner>
                  <strong class="text-success">Loading...</strong>
                </b-toast>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
module.exports = {
  data : function(){
    return {
      search: "",
      id_pengaduan: "",
      tgl_pengaduan: "",
      id_user: "",
      isi_laporan: "",
      foto: "",
      status: "",
      action: "",
      message: "",
      currentPage: 1,
      rows: 0,
      perPage: 10,
      key: "",
      data_pengaduan: [],
      fields: ["id_pengaduan", "tgl_pengaduan", "id_user", "isi_laporan", "status"]
    }
  },
  methods: {
    auth: function(){
      if ($store.getters.authLevel != "masyarakat") {
        this.$noty.error('Gagal anda bukan masyarakat!');
        localStorage.removeItem("Authorization")
        this.$router.push({name:'LoginMasyarakat'});
      } else {
        return next()
      }
    },
    getData : function(){
      let conf = { headers: { "Authorization" : 'Bearer ' + this.key } };
      let offset = (this.currentPage - 1) * this.perPage;
      this.$bvToast.show("loadingToast");
      this.axios.get("/penduduk/pengaduan/" + this.perPage + "/" + offset, conf)
      .then(response => {
        if(response.data.success == true){
          this.$bvToast.hide("loadingToast");
          this.data_pengaduan = response.data.data.pengaduan;
          this.rows = response.data.data.count;
        //   console.log(response)
        } else {
          this.$bvToast.hide("loadingToast");
          this.message = "Gagal menampilkan data."
        //   console.log(response)
          this.$router.push({name: "LoginMasyarakat"})
        }
        
      })
      .catch(error => {
        console.log(error);
      });
    },
    pagination : function(){
      if(this.search == ""){
        this.getData();
      } else {
        this.search();
      }
    },
  },
  mounted(){
    this.key = localStorage.getItem("Authorization");
    this.getData();
  }
}
</script>