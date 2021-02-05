<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button> -->
    <a class="navbar-brand" href="/">System</a>
    <span id="logout" @click="logout" v-if="isLoggedIn">Logut</span>
  </nav>
</template>

<script>
export default {
  props: ['isLoggedIn'],
  methods: {
    async logout () {
      this.$emit('loading', true)
      const { data } = await axios.post(API.logout)

      if ('error' in data) {
        console.log(data)
      } else {
        this.$emit('login', false)
        this.$router.push('/');
      }
      this.$emit('loading', false)
    }
  }
}
</script>
<style lang="scss" scoped>
  nav {
    justify-content: space-between;

    #logout {
      cursor: pointer;
      transition: .25s linear;
      font-weight: bold;

      &:hover {
        color: #00afd6;
      }
    }
  }
</style>
