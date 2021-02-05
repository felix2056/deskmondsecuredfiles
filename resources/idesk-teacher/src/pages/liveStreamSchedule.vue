<template>
<section class="content">
   <div class="content__inner">
      <div class="row">  
         <section id="scheduleLiveClass" class="col-sm-12 col-lg-4 mb-4">
            <div class="card">
               <div class="card-header">                  
                  <h6>Select a date and time</h6>
               </div>
                  <div class="card-body">
                     <form>
                        <div class="form-group">
                           <template>
                              <div>
                                 <label>Live class starts on</label>
                                 <b-form-datepicker id="endDate" v-model="livestream.startDate" class="mb-2"></b-form-datepicker>
                              </div>
                           </template>
                        </div>
                        <!--Times-->
                        <template>
                           <div id="timeslot" class="form-group">
                              <label>Choose a time</label>
                              <div class="custom-control custom-radio">
                                 <input type="radio" class="custom-control-input" name="level" v-model="livestream.startTime" value="08:40" id="timeslot1">
                                 <label class="custom-control-label d-flex justify-content-between" for="timeslot1">8:40 am <span class="badge badge-primary">First Period</span></label>
                              </div>
                              <div class="custom-control custom-radio">
                                 <input type="radio" class="custom-control-input" name="level" v-model="livestream.startTime" value="09:20" id="timeslot2">
                                 <label class="custom-control-label d-flex justify-content-between" for="timeslot2">9:20 am <span class="badge badge-primary">Seccond Period</span></label>
                              </div>
                              <div class="custom-control custom-radio">
                                 <input type="radio" class="custom-control-input" name="level" v-model="livestream.startTime" value="10:20" id="timeslot3">
                                 <label class="custom-control-label d-flex justify-content-between" for="timeslot3">10:20 am <span class="badge badge-primary">After Break</span></label>
                              </div>
                              <div class="custom-control custom-radio">
                                 <input type="radio" class="custom-control-input" name="level" v-model="livestream.startTime" value="13:20" id="timeslot4">
                                 <label class="custom-control-label d-flex justify-content-between" for="timeslot4">1:20 pm <span class="badge badge-primary">After Lunch</span></label>
                              </div>
                           </div>
                        </template>   
                        <!--end times-->
                        <!--subjects-->
                        <div class="form-group">
                           <label for="subject-choice">Subject</label>
                           <b-form-select v-model="livestream.subject_id"
                              :options="options"
                              class="mb-3"
                           ></b-form-select>
                        </div>
                        <!--end subjects-->
                        <div class="form-group">
                           <button type="button" class="btn btn-primary btn-lg btn-block" @click="onScheduleLiveClass">Schedule Live Class</button>
                        </div>
                     </form>
                  </div>
               </div>
         </section>
         <!--Dates chosen-->
         <section id="datesScheduled" class="col-sm-12 col-lg-7">
            <div class="card">
               <div class="card-header">                  
                  <h6>Live Class Streaming Schedule</h6>
               </div>
                  <div class="card-body">
                     <!--start table-->
                     <table class="table table-bordered mt-3">
                        <thead>
                           <tr>
                              <th scope="col">Date</th>
                              <th scope="col">Time</th>
                              <th scope="col">Subject</th>
                              <th scope="col">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr v-for="st in streamList" :key="st.id">
                              <th scope="row">{{st.startDate | formatdate}}</th>
                              <td>{{st.startTime}}</td>
                              <td><span :class="'badge '+st.subject.title">{{st.subject.title}}</span></td>
                              <td>
                                 <button type="button" class="btn btn-success" @click="startLiveStream(st.id)"><i class="icon start"></i></button>
                                 <button type="button" class="btn btn-danger" @click="delStream(st.id)"><i class="icon trash-white"></i></button>
                              </td>
                           </tr>
                           
                        </tbody>
                     </table>
                     <!--end table-->
               </div>
            </div>
         </section>
      </div>
   </div>
</section>
</template>

<script>
import moment from 'moment';

export default {
    layout: 'default',
    props: {
       class_id: {
          type: Number
       }
    },
    filters:{'formatdate':function(value){
         if(value){
               return moment(String(value)).format('LL')
         }
      }
    },
    data(){
        return {
            eventName: '',
            value: '',
            livestream: {
               startDate: '',
               startTime: '',
               subject_id: 0,
               status: 'New',
               class_id: this.class_id,
            },
            user: {},
            streamList: [],
            options:[
                     { value: null, text: 'Please select a subject' },
                  ],
        }
    },

   mounted(){
      // this.livestream.class_id = this.$store.state.classID;
      // this.onInit();
   },

    methods: {
       onInit(){
          //initialize the component
         this.$axios.get('/api/user').then(data=>{
            this.user = data.data;
            console.log('user-data', data);
         }).catch(err=>{
            console.log('err-data', err);
         })
         this.getStreamToday();
         this.getSubjects();
       },

      delStream(idx){
         //delete the component
         this.$axios.post('/api/delstream',{id:idx}).then(data=>{
            console.log('delete-res', data);
            this.streamList = data.data.streams;
         }).catch(err=>{
            console.log('delete-stream-err', err);
         })
      },

      getSubjects(){
         //pull the subjects
         this.$axios.get('/api/getSubjects').then((response)=>{
               console.log('subjects-get',response);
               response.data.subjects.forEach(element => {
                  let x = {
                     value: element.id,
                     text: element.title
                  }
                  this.options.push(x);
               });
         });
      },

      startLiveStream(cID){
         //this method will call the live stream screen and initiate the conference state
         //pass the conference ID to state var and call the livestream page to begin
         this.$axios.post('/api/setLiveStream',{
            ConfID: cID,
            status: 'On-going Live'
         }).then(() =>{
            this.$store.dispatch('setConfID', cID);
            this.$store.dispatch('setClassActive',this.livestream.class_id);
            this.$router.push('livestream');
            this.livestream.status = 'On-going';

         }).catch(err=>{
            this.flash('an Error Occured initiating live stream, please contact support!','warning');
            console.log('live-st-err', err);
         })
      },

      getStreamToday(){
         //pull list of uncompleted schedules from today
            this.$axios.post('/api/getstreamtoday').then(data=>{
               this.streamList = data.data.streams;
               console.log('stream-list', data);
            }).catch(err=>{
               console.log('stream-error',err);
            })
      },

      onScheduleLiveClass(){
         //this method will save or update the schedule above.
         this.$axios.post('/api/updatestream', this.livestream).then(data=>{
               console.log('save-stream', data);
               this.getStreamToday();
         }).catch(err=>{
            console.log('err-save-stream', err);
         })
      },


    },




}
</script>