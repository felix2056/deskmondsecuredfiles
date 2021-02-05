<template>
    <b-navbar>
        <template slot="brand">
          <b-navbar-item tag="router-link" :to="{ path: '/' }">
            <span class="has-text-weight-bold is-size-4">Tenant</span>
          </b-navbar-item>
        </template>
        <template slot="start">
        </template>

        <template slot="end" v-if="isLoggedIn">
          <b-navbar-item tag="div">
            <span class="cursor-pointer" @click="logout">Logout</span>
          </b-navbar-item>
        </template>
        <template slot="end" v-else>
          <b-navbar-item tag="router-link" :to="{ path: '/' }">
            <router-link to="/register">Register</router-link>
          </b-navbar-item>
          <b-navbar-item tag="router-link" :to="{ path: '/' }">
            <router-link to="/login">Login</router-link>
          </b-navbar-item>
        </template>
    </b-navbar>
</template>

<script>
export default {
  props: ['isLoggedIn'],
  methods: {
    async logout () {
      const { data } = await axios.post(API.logout)

      if ('error' in data) {
        console.log(data)
      } else {
        this.$emit('logout')
        this.$router.push('/login');
      }
    }
  }
}
</script>
<style lang="scss" scoped>
  .cursor-pointer {
    cursor: pointer;
  }
</style>