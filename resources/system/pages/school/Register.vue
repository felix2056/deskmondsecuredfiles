<template>
  <section>
    <div class="container">
      <div class="alert alert-warning alert-dismissible fade show" role="alert" v-if="error.length">
        {{ error }}
        <button type="button" class="close" @click="error = ''" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card">
        <div class="form-group">
          <div class="card-body">
            <div class="card-title">Register School</div>
            <label for="name">School Name</label>
            <input type="text" class="form-control" id="name" name="name" v-model="form.name">
            <label for="domain">Domain</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="domain" name="domain" v-model="form.domain" @input="removeWhiteSpace">
              <div class="input-group-append">
                <span class="input-group-text" id="basic-addon2">{{ `.${domain}` }}</span>
              </div>
            </div>
            <label for="admin_name">School Admin's Name</label>
            <input type="text" class="form-control" id="admin_name" name="admin_name" v-model="form.admin_name">
            <label for="email">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" v-model="form.email">

            <button class="btn btn-primary mt-5" @click="register">Register</button>
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
      domain: process.env.MIX_DOMAIN_NAME,
    error: '',
      form: {
        name: '',
        domain: '',
        admin_name: '',
        email: ''
      }
    }
  },
  methods: {
    removeWhiteSpace () {
      this.form.domain = this.form.domain.toLowerCase().replace(/[^0-9|a-z|]/g, '')
    },
    async register () {
      this.$emit('loading', true)
      const { name, domain, admin_name, email } = this.form
      const { data } = await axios.post(API.registerSchool, {
        name, domain, admin_name, email
      })
      this.$emit('loading', false)
      if ('error' in data) {
        this.error = data.error
      } else {
        window.location.href = data.redirect
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
  .error-message {
    height: 1.4rem;
    min-width: 15px;
    margin: auto;
  }
</style>
