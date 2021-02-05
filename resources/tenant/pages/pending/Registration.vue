<template>
  <section class="container pt-100">
    <div class="content__inner">
      <div class="row">
        <b-message type="is-info" has-icon class="mt-3">
        Provide a password to register this user as the admin for this domain and complete the registration.
      </b-message>
      <div class="card mt-4">
        <div>
          <div class="card-content">
              <b-field label="Password">
                <b-input name="password" type="password" :disabled="loading" v-model="form.password" password-reveal/>
              </b-field>
              <b-field label="Confirm Password">
                <b-input name="confirm_password" type="password" :disabled="loading" v-model="form.confirm_password" password-reveal/>
              </b-field>
              <div class="py-3 has-text-centered has-text-danger">{{ error }}</div>
          </div>
          <footer class="card-footer">
            <div class="card-footer-item">
              <b-button @click="submit" :disabled="allowSubmit" :class="{ 'is-loading': loading }" variant="primary">
                {{ loading ? '' : 'Submit' }} <i v-show="loading" class="fa fa-spinner fa-spin"></i>
              </b-button>
            </div>
          </footer>
        </div>
      </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data () {
    return {
      post: '/api/complete-registration',
      error: '',
      loading: false,
      form: {
        password: '',
        confirm_password: ''
      }
    }
  },
  computed: {
    allowSubmit () {
      return (this.form.password.length && this.form.confirm_password.length) ? false : true
    }
  },
  methods: {
    async submit () {
      this.loading = true
      const { password, confirm_password } = this.form
      const { data } = await axios.post(API.completeRegistration, {
        password, confirm_password
      })
      if ('error' in data) {
        this.loading = false
        this.error = data.error
      } else {
        this.$router.push({name: 'AdminLogin'})
        this.loading = false
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  .card {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
  }
</style>
