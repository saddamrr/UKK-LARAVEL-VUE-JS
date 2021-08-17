<template>
  <div>
    <div class="container mt-3">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <p class="card-title float-left"><b>Buat Pengaduan</b></p>
              <p class="card-description float-right">
                <b-button variant="success" v-b-modal.modalTatib v-on:click="Add"><i class="mdi mdi-plus btn-icon-prepend"></i> Tambah Pengaduan</b-button>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <b-modal 
      id="modalTatib"
      @ok="Save"
    >
      <template v-slot:modal-title>
        Isikan Pengaduan
      </template>
        <form ref="form">
          <div class="form-group">
              <label for="isi_laporan" class="col-form-label">Isi Laporan</label>
              <b-form-textarea id="textarea" v-model="isi_laporan" placeholder="Isi laporan pengaduan" rows="3" max-rows="6"></b-form-textarea>
          </div>
          <div class="form-group">
            <label for="foto" class="col-form-label">Tambahkan Foto</label>
            <b-form-file
            v-model="foto"
            placeholder="" @change="fotoChange"
            ></b-form-file>
          </div>
        </form>
    </b-modal>

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
      fields: ["id_pengaduan", "tgl_pengaduan", "id_user", "isi_laporan", "foto", "status"]
    }
  },

  methods: {
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
          console.log(response)
        } else {
          this.$bvToast.hide("loadingToast");
          this.message = "Gagal menampilkan data."
          
        //   this.$router.push({name: "LoginMasyarakat"})
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
        this.searching();
      }
    },

    Add : function(){
      this.action = "insert"
      this.id_pengaduan = ""
      this.tgl_pengaduan = ""
      this.id_user = this.$store.getters.userDetail.id
      this.isi_laporan = ""
      this.foto = ""
      this.status = ""
    },

    Save : function(){
      let conf = { headers: { "Authorization" : 'Bearer ' + this.key } };
      this.$bvToast.show("loadingToast");

      if(this.action === "insert"){
        let form = new FormData();

        form.append("id_pengaduan", this.id_pengaduan);
        form.append("tgl_pengaduan", this.tgl_pengaduan);
        form.append("id_user", this.id_user);
        form.append("isi_laporan", this.isi_laporan);
        form.append("foto", this.foto);
        form.append("status", this.status);
        this.axios.post("/penduduk/pengaduan", form, conf)
        .then(response => {
          this.$bvToast.hide("loadingToast");
          if(this.search == ""){
            this.getData();
          } else {
            this.searching();
          }
          this.message = response.data.message;
          this.$noty.success('Berhasil mengirimkan pengaduan');
          this.$router.push({name:'DashboardMasyarakat'});
        })
        .catch(error => {
          console.log(error);
        });
      } else {

      }
    },
  },
  mounted(){
    this.key = localStorage.getItem("Authorization");
    this.getData();
  }
}
</script>