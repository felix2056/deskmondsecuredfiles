<template>
  <div>
    <header class="header" style="background-color: #ffc107;">
      <div class="navigation-trigger hidden-xl-up d-lg-none" data-ma-action="aside-open" data-ma-target=".sidebar">
        <div class="navigation-trigger__inner"> <i class="navigation-trigger__line"></i> <i class="navigation-trigger__line"></i> <i class="navigation-trigger__line"></i> </div>
      </div>
      <div class="header__logo">
        <h1><a href="/">Learn<span> With Me</span></a></h1>
      </div>
    </header>

    <sidebar/>
    
    <FlashMessage :position="'right top'"></FlashMessage>
    
    <router-view />
    <footerline/>
  </div>
</template>

<script>
import footerline from '../components/Footerline'
import sidebar from '../components/Sidebar'

// axios.defaults.baseURL='http://lwmv2-gat.test';
// //axios.defaults.baseURL='https://api.deskmond.com';
// axios.defaults.withCredentials = true;
// axios.defaults.crossDomain = true;

export default {
  components:{
    sidebar,
    footerline
  },
  data(){
    return {
      user: {},
    }
  },

  // mounted(){
  //   this.getUser();
  // },

  methods:{
    logout(){
      // this.$axios.post('/logout').then(res=>{
      //   this.$router.push('index');
      // })
      this.$store.dispatch('logout');
    },

    getUser(){
        this.$axios.get('/api/user').then(res=>{
            console.log('user', res);
            this.user = res.data;
        })
    },
  }
}
</script>


<style>
html {
  font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI',
    Roboto, 'Helvetica Neue', Arial, sans-serif;
  font-size: 16px;
  word-spacing: 1px;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
  -moz-osx-font-smoothing: grayscale;
  -webkit-font-smoothing: antialiased;
  box-sizing: border-box;
}

*,
*:before,
*:after {
  box-sizing: border-box;
  margin: 0;
}

.button--green {
  display: inline-block;
  border-radius: 4px;
  border: 1px solid #3b8070;
  color: #3b8070;
  text-decoration: none;
  padding: 10px 30px;
}

.button--green:hover {
  color: #fff;
  background-color: #3b8070;
}

.button--grey {
  display: inline-block;
  border-radius: 4px;
  border: 1px solid #35495e;
  color: #35495e;
  text-decoration: none;
  padding: 10px 30px;
  margin-left: 15px;
}

.button--grey:hover {
  color: #fff;
  background-color: #35495e;
}
</style>
