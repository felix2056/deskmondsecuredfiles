<template>
  <div>
    <aside class="sidebar">
      <div class="scrollbar-inner">
        <ul class="navigation">
          <li><router-link :to="{ name: 'dashboard' }"><i class="icon desk"></i>Desk</router-link></li>
          <li><router-link :to="{ name: 'browse-classes' }"><i class="icon my-classes"></i>Browse Classes</router-link></li>
          <li><router-link :to="{ name: 'myclass' }"><i class="icon settings"></i>Settings</router-link></li>
          <li><router-link :to="{ name: 'myclass' }"><i class="icon my-quizzes"></i>My Quizzes</router-link></li>
          <li><router-link :to="{ name: 'myclass' }"><i class="icon my-plans"></i>My Plans</router-link></li>
          <li><router-link :to="{ name: 'myclass' }"><i class="icon my-exams"></i>My Exams</router-link></li>
          <li><router-link :to="{ name: 'myclass' }"><i class="icon settings"></i>Settings</router-link></li>
          <li><a @click="logout()"><i class="icon logout"></i>Logout</a></li>
        </ul>
      </div>
    </aside>
  </div>
</template>

<script>
export default {
  data(){
    return{
      userInfo: '',
      userRole: '',
    }
  },
  mounted(){
  },
  computed:{
  },
  methods:{
    async logout(){
      const { data } = await axios.post('/api/composite/logout')

      if ('error' in data) {
        console.log(data)
      } else {
        this.$emit('logout')
        // this.$router.push('/login')
        window.location.href = '/login'
      }
    }
  }
}
</script>

<style scoped>

</style>