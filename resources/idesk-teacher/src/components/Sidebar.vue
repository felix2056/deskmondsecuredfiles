<template>
        <aside class="sidebar">
            <div class="scrollbar-inner">
                <ul class="navigation">
                    <li><router-link :to="{ name: 'dashboard' }"><i class="icon dashboard"></i>Dashboard</router-link></li>
                    <li><router-link :to="{ name: 'my-classes' }"><i class="icon my-classes"></i>My Classes</router-link></li>
                    <li><router-link :to="{ name: 'live-stream-schedule' }"><i class="icon streaming-offline"></i>My Live Streams</router-link></li>
                    <!-- <li><router-link to="/myClasses"><i class="icon my-quizzes"></i>My Quizzes</router-link></li>
                    <li><router-link to="/myClasses"><i class="icon my-plans"></i>My Plans</router-link></li>
                    <li><router-link to="/myClasses"><i class="icon my-exams"></i>My Exams</router-link></li> -->
                    <li><router-link :to="{ name: 'my-classes' }"><i class="icon settings"></i>Settings</router-link></li> 
                    <li><a @click="logout()"><i class="icon logout"></i>Logout</a></li>
                </ul>
            </div>
        </aside>
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
    async logout () {
      const { data } = await axios.post('/api/composite/logout')
      if ('error' in data) {
        console.log(data)
      } else {
        this.$emit('logout')
        window.location.href = '/teacher'
      }
    }
}
}
</script>

<style scoped>

</style>