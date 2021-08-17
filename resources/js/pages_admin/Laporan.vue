<template>
    <div class="container-fluid page-body-wrapper">
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <p class="card-title float-left"><b>Data Laporan</b></p>
                    <form @submit.prevent="handleSubmit">
                        <div class="form-group">
                            <label for="tahun" class="col-form-label">Tahun</label>
                            <input type="number" name="tahun" class="form-control" id="tahun" placeholder="Tahun" v-model="tahun">
                        </div><br>
                        <button class="btn btn-primary" type="submit">Cari Data</button>
                    </form>
                    <div class="table-responsive">
                        <b-table striped hover :items="laporan" :fields="fields">

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
    data:function() {
        return {
            search: "",
            tahun: "",
            key: "",
            laporan: [],
            fields: ["tgl_pengaduan", "isi_laporan", "status", "nama"]
        }
    },

    methods: {
        handleSubmit(){
            let conf = { headers: { "Authorization" : 'Bearer ' + this.key } };
            let form = new FormData();
            form.append("tahun", this.tahun);
            this.$bvToast.show("loadingToast");
            this.axios.post("/pengaduan/laporan", form, conf)
            .then(response => {
                if (response.data.success == true) {
                    this.$bvToast.hide("loadingToast");
                    this.laporan = response.data.data;
                    this.$noty.success('Berhasil mendapatkan data')
                } else {
                    this.$noty
                }
            })
            .catch(error => {
                console.log(error);
            })
        }
    },
    printme(){
        window.print();
    },
    mounted(){
        this.key = localStorage.getItem("Authorization");
    }
}
</script>