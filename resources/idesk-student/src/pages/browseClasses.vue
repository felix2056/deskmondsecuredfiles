<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <section id="pupilsClasses" class="col-lg-12 col-sm-12">
          <!--list classes here-->
          <div class="row">
            <!-- all livestream NOW -->
            <div v-if="livestreams != undefined">
              <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-4" v-for="livest in livestreams" :key="livest.id">
                <div class="card h-100">
                  <div class="streaming"><i class="icon streaming-offline"></i></div>
                  <img :src="'/images/'+livest.subjectTitle+'.png'" class="card-img-top" alt="">
                  <div class="card-body d-flex justify-content-between flex-column">
                    <h5 class="card-title mb-3">{{livest.title}}</h5>
                    <button class="btn btn-secondary btn-lg btn-block" disabled @click="startLiveClass(livest.id)">Join Live Class</button>
                  </div>
                  <div class="card-footer">
                    <small class="text-muted">{{livest.startDate | formatdate}} {{livest.startTime |formatTime}}</small>
                  </div>
                </div>
              </div>
            </div>

            <!-- all livestream scheduled classes -->
            <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-4" v-for="schtoday in schedtoday" :key="schtoday.id">
              <div class="card h-100">
                <div class="streaming"><i class="icon streaming-offline"></i></div>
                <img :src="'/images/'+schtoday.subjectTitle+'.png'" class="card-img-top" alt="">
                <div class="card-body d-flex justify-content-between flex-column">
                  <h5 class="card-title mb-3">{{schtoday.subject.title}}</h5>
                  <button class="btn btn-secondary btn-lg btn-block disabled" @click="startLiveClass(schtoday.id)">Join Live Class</button>
                </div>
                <div class="card-footer">
                  <small class="text-muted">{{schtoday.startDate | formatdate}} {{schtoday.startTime |formatTime}}</small>
                </div>
              </div>
            </div>

            <!-- other not shceduled classes here -->
            <div v-for="classx in classesxx" :key="classx.id" class="col-12 col-md-6 col-lg-6 col-xl-4 mb-4">
              <div class="card h-100">
                <img :src="'/images/'+classx.subjectTitle+'.png'" class="card-img-top" alt="">
                <div class="card-body d-flex justify-content-between flex-column">
                  <h5 class="card-title mb-3">{{classx.classTitle}}</h5>
                  <p></p>
                  <button href="#" @click="startClass(classx.id)" class="btn btn-primary btn-lg btn-block">Join Class</button>
                </div>
                <div class="card-footer">
                  <small class="text-muted">{{classx.submissionDate | formatSubmitDate}}</small>
                </div>
              </div>
            </div>
          </div>
          <!--end classes-->
        </section>
        <!--end row-->
      </div>
    </div>
  </section>
</template>

<script>
// import Techclass from '@/components/Techclass.vue';
import moment from 'moment';

export default {
  // components: {
  //     Techclass,
  // },
  computed:{
  },

  filters:{
      'formatdate':function(value){
          if(value){
              // return moment(String(value)).format('LL')
              // rehashed to display today or tomorrow 
              var today = moment(new Date()).format('YYYY-MM-DD');
              var sdate = moment(value).format('YYYY-MM-DD');
              if(sdate == today){
                  return 'Today @';
              }else if(sdate > today){
                  return 'Tomorrow @';
              }else {
                  return moment(String(value)).format('LL');
              }
          }
      },

      'formatTime':function(value){
          if(value){
              return moment(String(value),'hh:mm a').format('hh:mm a')
          }
      },

      'formatSubmitDate': function(value){
          return moment(String(value)).format('LL')
      }
  },

  data(){
      return{
          userInfo: {},
          reminderLiveStream: false,
          classesxx: [],
          classesraw: {},
          classesDraft: [],
          livestreams: [],
          schedtoday:[],
          livest:[],
          marklist: [],
          subjects: {},
      }
  },

  mounted(){
      this.onInit()
  },

  methods:{
        onInit(){
          // This api is to get live class
          axios.get('/api/getBrowseClasses', { withCredentials: true })
          .then(res=>{
              console.log('classes-', res);
              this.classesraw = res.data.classes;
              this.userInfo = res.data.student;
              this.classesxx = [];

              res.data.classes.forEach(element=>{
                  let x = element.subject;
                  
                  if(x != undefined) {
                      x.classTitle = element.title;
                      x.subjectTitle = x.title.replace(/[^a-z0-9]/gi, '-');
                      x.submissionDate = element.submissionDate;
                  }

                  this.classesxx.push(x);
              });
          }).catch(err=>{
              console.log('get-classes-err', err);
          });

      },

      getFeedback(id){
        return this.$router.push({name: 'feedback', query: {answer_id: id} });
      },

      getTeacherClasses(){
          this.$axios.get('/api/getTeacherClasses',{
              headers: {
                  'X-Requested-With' : 'XMLHttpRequest',
                  'Content-Type': 'multipart/form-data'
              },
              withCredentials: true,
          })
          .then(response => {
              console.log('res-data',response);

              response.data.classDrafts.forEach(element => {
                    let x = {
                      id: element.id,
                      subject: element.subject.title,
                      title: element.title,
                      startDate: element.startDate,
                      submissionDate: element.submissionDate,
                    }
                    this.classesDraft.push(x);
                });
              response.data.classScheduled.forEach(element => {
                    let x = {
                      id: element.id,
                      subject: element.subject.title,
                      title: element.title,
                      startDate: element.startDate,
                      submissionDate: element.submissionDate,
                    }
                    this.classes.push(x);
                });
          }).catch(err=>{
              if(err.message == 'Unauthenticated'){
                  this.flash('Your session has ended.  You will be logged out. Please login again to use the System','warning');
                  this.$store.dispatch('logout');
              }
          })
      },

      startClass(id){
          this.$store.dispatch('setClassID',id)
          this.$router.push('myclass')
      },

      startLiveClass(cID){
          //this method will start the live class session 
          this.$store.dispatch('setConfID', cID);
          this.$router.push('livestream');
      }

  }
}
</script>

<style scoped>

</style>