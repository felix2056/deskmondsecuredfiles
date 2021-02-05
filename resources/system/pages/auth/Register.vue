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
        <div class="card-body">
          <div class="card-title">Register as Admin</div>
          <div class="form-group">
            <label for="name">Name</label>
            <input type="name" :class="['form-control', { 'is-invalid' : invalid('name') }]" id="name" name="name" v-model="form.name" required>
            <small class="form-text text-danger">
              {{ validator.name[0] }}
            </small>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" :class="['form-control', { 'is-invalid' : invalid('email') }]" id="email" name="email" v-model="form.email" required>
            <small class="form-text text-danger">
              {{ validator.email[0] }}
            </small>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" :class="['form-control', { 'is-invalid' : invalid('password') }]" id="password" name="password" v-model="form.password" required>
            <small class="form-text text-danger">
              {{ validator.password[0] }}
            </small>
          </div>
          <div class="form-group">
            <label for="confirm_password">Verify Password</label>
            <input type="password" :class="['form-control', { 'is-invalid' : invalid('confirm_password') }]" id="confirm_password" name="confirm_password" v-model="form.confirm_password" required>
            <small class="form-text text-danger">
              {{ validator.confirm_password[0] }}
            </small>
          </div>

          <div class="row justify-content-between align-items-end custom-x-padding">
            <div class="column">
              <button class="btn btn-primary mt-5" @click="register">Register</button>
            </div>
            <div class="column">
              <router-link to="/">I have an account</router-link>
            </div>
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
      error: '',
      form: {
        name: '',
        email: '',
        password: '',
        confirm_password: '',
      },
      validator: {
        name: '',
        email: '',
        password: '',
        confirm_password: ''
      },
      validated: false
    }
  },
  methods: {
    register () {
      this.validator = {
        name: [],
        email: [],
        password: [],
        confirm_password: []
      }
      this.validated = false
      this.$emit('loading', true)
      const { name, email, password, confirm_password } = this.form
      axios.post(API.register, {
        name, email, password, confirm_password
      })
        .then (({data, status}) => {
          if ('error' in data) {
            this.error = data.error
          } else if ('validator' in data) {
            this.validator = {
              ...this.validator,
              ...data.validator
            }
            this.validated = true
          } else if (`${status}` === '200') {
            this.$router.push('/')
          }
          this.$emit('loading', false)
        })
    },
    invalid (field) {
      if (this.validator[`${field}`] === '' && this.validated) {
        return true
      } else {
        return false
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
  .custom-x-padding {
    padding: 0 1.25rem;
  }
</style>