<template>
  <div style="height: 100vh">
    <div class="card">
      <p class="title is-5">
        Register your School
      </p>
      <b-field label="School Name">
        <b-input v-model="form.name" icon="home-city" required />
      </b-field>
      <b-field message="" label="Domain">
        <b-input  v-model="form.domain" @input="removeWhiteSpace" expanded required />
          <p class="control">
            <span class="button is-static">{{ `.${domain}` }}</span>
          </p>
      </b-field>
      <b-field label="School Admin's Name">
        <b-input v-model="form.admin_name" icon="account" required />
      </b-field>
      <b-field label="email">
        <b-input v-model="form.email" type="email" icon="email" required />
      </b-field>
      <div class="mt-6">
        <b-button type="is-primary" @click="register">Register</b-button>
      </div>
    </div>
  </div>
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
        this.snackbar(this.error)
      } else {
        window.location.href = data.redirect
      }
    },
    snackbar (error) {
      const msg = this.$buefy.snackbar.open({
        message: `${error}`,
        type: 'is-warning',
        position: 'is-top',
        actionText: 'Close',
        indefinite: true,
        onAction: () => {
          msg.close()
        }
      })
    }
  }

}
</script>

<style style="scss" scoped>
  .card {
    max-width: 420px;
    width: 100%;
    margin: 5rem auto;
    border-radius: 25px;
    padding: 1.75em 1.5em;

    .field {
      margin-bottom: 1.5rem;
    }
  }
</style>