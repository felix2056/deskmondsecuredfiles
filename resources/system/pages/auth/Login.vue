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
          <div class="card-title">Login</div>
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
          <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" v-model="form.remember" id="remember" name="remember">
            <label class="form-check-label" for="remember">
              Remember me
            </label>
          </div>

          <div class="row justify-content-between align-items-end custom-x-padding">
            <div class="column">
              <button class="btn btn-primary mt-5" @click="login">Log In</button>
            </div>
            <div class="column">
              <router-link to="/register">Dont have an account</router-link>
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
        email: '',
        password: '',
        remember: true
      },
      validator: {
        email: [],
        password: []
      },
      validated: false
    }
  },
  methods: {
    async login () {
      this.validator = { email: '', password: '' }
        this.validated = false
      this.$emit('loading', true)
      const { email, password, remember } = this.form
      const { data } = await axios.post(API.login, {
        email, password, remember
      })
      if ('error' in data) {
        this.error = data.error
      } else if ('validator' in data) {
        this.validator = {
          ...this.validator,
          ...data.validator
        }
        this.validated = true
      } else {
        this.$emit('login', true);
        this.$router.push('/admin')
      }
      this.$emit('loading', false)
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