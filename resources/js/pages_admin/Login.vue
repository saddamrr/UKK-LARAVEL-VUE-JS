<template>
    <div class="container">
        <div>
            <form class="text-center tengah" v-on:submit.prevent="Login" method="post">
                <h1 class="h3 mb-3 fw-normal">Login Admin</h1>

                <div class="form-floating">
                <input type="username" class="form-control" id="floatingInput" placeholder="Username" v-model="username" name="username">
                <label for="floatingInput">Username</label>
                </div><br>
                <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" v-model="password" name="passwrod">
                <label for="floatingPassword">Password</label>
                </div>
                <br>
                <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Login</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            username: '',
            password: ''
        }
    },
    methods: {
        Login: function() {
            let username = this.username
            let password = this.password
            this.$store.dispatch('login', {username, password})
            .then(() => 
                this.$router.push({name:'DashboardAdmin'}
            ))
            .catch(err => {
                this.$noty.error('Username dan password salah');
            })
        }
    }
}
</script>

<style>
.tengah {
    padding: 20%;
}
</style>