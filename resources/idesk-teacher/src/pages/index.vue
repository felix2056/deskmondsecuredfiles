<template>
  <b-container >
    <div class="container-fluid h-100 d-flex flex-column">
      <div class="row flex-grow-1 flex-shrink-0">
        <div class="col-12 d-flex align-items-center pt-5 mt-5">
          <div class="col-sm-12 col-md-10 col-lg-5 mx-auto">
            <div class="card">
              <b-card>
                <b-card-text>
                  <p>Welcome! A new way of learning On-line using live video and curriculum</p>
                  <flash-message/>
                  <b-form @submit="onSubmit"  @reset="onReset" >
                    <b-form-group label="Email">
                      <b-form-input
                      id="input-1"
                      name="email"
                      v-model="form.email"
                      type="email"
                      required
                      placeholder="Enter your Email"
                      />
                    </b-form-group>
                    <b-form-group
                    id="input-2"
                    label="Password"
                    label-for="input-2"
                    >
                      <b-form-input
                      id="input-2"
                      v-model="form.password"
                      type="password"
                      required
                      />
                    </b-form-group>
                    <b-button type="submit" variant="primary">Login</b-button>
                  </b-form>
                </b-card-text>
              </b-card>
            </div>
          </div>
        </div>
      </div>
    </div>
  </b-container>
</template>

<script>


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
            // //form submit method
            // evt.preventDefault();

            // this.$axios.get('/sanctum/csrf-cookie',{
            //     headers: {
            //         'X-Requested-With' : 'XMLHttpRequest'
            //     },
            //     withCredentials: true,
            // }).then(response => {
            //   this.$auth.loginWith('local', {
            //       data: {
            //             email: this.form.email,
            //         password: this.form.password,
            //       }
            //   }).then(res=>{
            //        this.$store.dispatch('setLogin',true);
            //        this.$store.dispatch('setToken');
            //        this.$router.push('dashboard');
            //    }).catch(err=>{
            //        this.flash('These credentials do not match our records','error');
            //        this.$store.dispatch('setLogout', true);
            //    })
            // });
        },

        onReset(){
            //reset the form
        }
    }
}
</script>