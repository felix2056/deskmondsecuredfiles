<template>
    <div class="container-fluid h-100 d-flex flex-column">
        <div class="row flex-grow-1 flex-shrink-0">
        <div class="col-12 d-flex align-items-center pt-5 mt-5">
            <div class="col-sm-12 col-md-7 col-lg-3 mx-auto">
                <div class="card">
                    <flash-message/>
                    <div class="card-body">
                    <h5 class="text-center mb-3">Login</h5>
                    <form method="POST">
                        <div class="form-label-group">
                            <label for="inputEmail">Email</label>
                            <input type="email" id="inputEmail" v-model="form.email" class="form-control form-control-lg" placeholder="Email you used to register" required>
                            <label for="inputPassword" class="mt-2">Password</label>
                            <input type="password" id="inputPassword" v-model="form.password" class="form-control form-control-lg" placeholder="Your password" required>
                        </div>
                        <template>
                            <div class="mt-2">
                                <b-overlay rounded opacity="0.6" spinner-small spinner-variant="primary" >
                                <b-button ref="button" block variant="primary" size="lg" @click="onSubmit">
                                    Login
                                </b-button>
                                </b-overlay>
                            </div>
                        </template>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
axios.defaults.baseURL='http://lwmv2-gat.test';
axios.defaults.withCredentials = true;

export default {
    layout: 'starter',
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            error: '',
        }
    },

    mounted(){

    },

    methods:{
        onSubmit(){
            //form submit method
            axios.get('/sanctum/csrf-cookie').then(response => {
                console.log('sanctum csrf', response);
                this.$store.dispatch('setToken');
                axios.post('/login', {
                    email: this.form.email,
                    password: this.form.password,
                }).then(() =>{
                    this.$store.dispatch('setLogin', true);
                    this.$router.push('dashboard');
                }).catch(() =>{
                    this.$store.dispatch('setLogin', false);
                    this.flash('These Credentials Do Not Match our Records','warning');
                })
            });
        }
    }
}
</script>