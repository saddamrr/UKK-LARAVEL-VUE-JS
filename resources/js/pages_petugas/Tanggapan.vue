<template>
    <div class="container-fluid page-body-wrapper">
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <p class="card-title float-left"><b>Data Pengaduan</b></p>
                    <p class="card-description float-right">
                <b-button variant="success" v-b-modal.modalTanggapan v-on:click="Add"><i class="mdi mdi-plus btn-icon-prepend"></i>Beri Tanggapan</b-button>
              </p>
                    <div class="table-responsive">
                        <b-table striped hover :items="data_pengaduan" :fields="fields">
                        <!--<template v-slot:cell(role)="data">
                            <b-badge variant="warning">{{ data.item.role }}</b-badge>
                        </template>-->
                        <!-- <template v-slot:cell(action)="data">
                            <b-button size="sm" variant="danger" v-on:click="Drop(data.item.id)"><i class="mdi mdi-delete btn-icon-prepend"></i> Hapus</b-button>
                        </template> -->
                        </b-table>
                        <b-pagination
                        v-model="currentPage"
                        :per-page="perPage"
                        :total-rows="rows"
                        align="center"
                        v-on:input="pagination">
                        </b-pagination>

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

    <b-modal 
      id="modalTanggapan"
      @ok="Save"
    >
      <template v-slot:modal-title>
        Form Ubah Status
      </template>
        <form ref="form">
        <div class="form-group">
            <label for="id_pengaduan" class="col-form-label">ID Pengaduan</label>
            <input type="number" name="id_pengaduan" class="form-control" id="id_pengaduan" placeholder="ID Pengaduan" v-model="id_pengaduan">
          </div>
          <div class="form-group">
            <div class="form-group">
              <label for="tanggapan" class="col-form-label">Isi Tanggapan</label>
              <b-form-textarea id="tanggapan" v-model="tanggapan" placeholder="Isi tanggapan pengaduan" rows="3" max-rows="6"></b-form-textarea>
          </div>
          </div>
        </form>
    </b-modal>

  </div>
</template>

<script>
module.exports = {
    data:function() {
        return {
            search: "",
            id_tanggapan: "",
            id_pengaduan: "",
            tgl_tanggapan: "",
            tanggapan: "",
            id_petugas: "",
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
        getData : function(){
        let conf = { headers: { "Authorization" : 'Bearer ' + this.key } };
        let offset = (this.currentPage - 1) * this.perPage;
        this.$bvToast.show("loadingToast");
        this.axios.get("pengaduan", conf)
        .then(response => {
            if(response.data.success == true){
            this.$bvToast.hide("loadingToast");
            this.data_pengaduan = response.data.data.pengaduan;
            this.rows = response.data.data.count;
            console.log(response)
            } else {
            this.$bvToast.hide("loadingToast");
            this.message = "Gagal menampilkan data."
            console.log(response)
            //   this.$router.push({name: "LoginAdmin"})
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

        Add: function(){
             this.action = "isiTanggapan";
             this.id_tanggapan = "";
             this.id_pengaduan = "";
             this.tgl_tanggapan ="";
             this.tanggapan = "";
             this.id_petugas ="";
        },

        Save: function(){
            let conf = { headers: {"Authorization" : 'Bearer' + this.key}};
            this.$bvToast.show("loadingToast");
            if (this.action == "isiTanggapan") {
                let form = new FormData();
                form.append("id_pengaduan", this.id_pengaduan);
                form.append("tanggapan", this.tanggapan);

                this.axios.post("/pengaduan/tanggapan", form, conf)
                .then(response => {
                    this.$bvToast.hide("loadingToast");
                    if(this.search == ""){
                        this.getData();
                    } else {
                        this.searching();
                    }
                    this.$noty.success(response.data.message);
                }).catch(error => {
                    console.log(error);
                });
                this.$router.push({name:'UbahStatusPetugas'})
            } else {

            }
        },

        Drop: function(id){
            let conf = { headers: {"Authorization" : 'Bearer' + this.key}};
            if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
                this.$bvToast.show("loadingToast");
                this.axios.delete("/masyarakat/" + this.id, conf)
                .then(response => {
                    this.getData();
                    this.$bvToast.hide("loadingToast");
                    this.message = response.data.message;
                    this.$bvToast.show("message");
                }).catch(error => {
                console.log(error);
                });
            }
        },
    },
    mounted(){
        this.key = localStorage.getItem("Authorization");
        this.getData();
    }
}
</script>