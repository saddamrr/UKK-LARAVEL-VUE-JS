<template>
    <div class="container">
        <div>
            <form class="text-center tengah">
                <h1 class="h3 mb-3 fw-normal">Register Masyarakat</h1>

                <div class="form-floating">
                <input type="number" class="form-control" id="nik" placeholder="NIK" v-model="form.nik">
                <label for="floatingInput">NIK</label>
                </div>
                <div class="error" v-if="errors.nik">
                    {{errors.nik[0]}}
                </div>
                <div class="form-floating">
                <input type="text" class="form-control" id="nama" placeholder="Nama" v-model="form.nama">
                <label for="floatingInput">Nama</label>
                </div>
                <div class="error" v-if="errors.nama">
                    {{errors.nama[0]}}
                </div>
                <div class="form-floating">
                <input type="username" class="form-control" id="username" placeholder="Username" v-model="form.username">
                <label for="floatingInput">Username</label>
                </div>
                <div class="error" v-if="errors.username">
                    {{errors.username[0]}}
                </div>
                <div class="form-floating">
                <input type="password" class="form-control" id="password" placeholder="Password" v-model="form.password">
                <label for="floatingPassword">Password</label>
                </div>
                <div class="error" v-if="errors.password">
                    {{errors.password[0]}}
                </div>
                <div class="form-floating">
                <input type="number" class="form-control" id="telp" placeholder="Nomor Telepon" v-model="form.telp">
                <label for="floatingInput">Nomor Telepon</label>
                </div>
                <div class="error" v-if="errors.telp">
                    {{errors.telp[0]}}
                </div>
                <br>
                <button class="w-100 btn btn-lg btn-primary" @click.prevent="submit">Register</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                nik: '',
                nama: '',
                username: '',
                password: '',
                telp: ''
            },
            errors: {}
        }
    },
    methods: {
        submit() {
            axios.post('/register', this.form).then((response) => {
                if (response.data.success == true) {
                    console.log(response)
                    this.$noty.success(response.data.message)
                    this.$router.push({name:'LoginMasyarakat'})
                }
            }).catch((error) => {
                if (error.response.success == false) {
                    this.errors = error.response.data.message
                }
            })
        }
    }
}
</script>

<style>
.tengah{
    padding: 20%;
}
</style>