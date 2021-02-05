<template>
    <div id="paaralan-container" v-if="!closeMeetingRoom">
    </div>
</template>

<script>

export default{
  data(){
    return {
      room:'student-test',
      pass: 'known',
      username: 'test',
      api: {},
      closeMeetingRoom: false,
      teachInfo: {}
    }
  },

  // mounted(){
  //   //get the info of the user
  //   //find the current user - assume it can be a teacher or student
  //   this.$axios.get('/api/user').then(data=>{
  //     console.log('user-data',data);
  //     this.teachInfo = data.data;
  //     this.username = data.data.firstName;
  //     var cID = this.$store.state.confID;
  //     this.getConferenceDetails(cID);
  //   });
  // },

  // methods: {
  //     getConferenceDetails(cID){
  //         //this method extracts the conference codes from the schedule,
  //         //this will extract room details based on conference id
  //         console.log('conf', cID);

  //         this.$axios.post('/api/conference',{
  //             ConfID : cID
  //         }).then(data=>{
  //             console.log('conf-data', data);
  //             this.room = data.data.room_id;
  //             this.pass = data.data.key;
  //             this.openRoom();
  //         }).catch(err => {
  //             console.log('conf-err', err);
  //         })
  //     },

  //     startConference(){
  //         var _this = this
  //           try {
  //                 const domain = 'meet.velum.site';
  //                 const options = {
  //                     audioInput: '<deviceLabel>',
  //                         audioOutput: '<deviceLabel>',
  //                         videoInput: '<deviceLabel>',
  //                     roomName: this.room,
  //                     height: 400,
  //                     parentNode: document.getElementById('paaralan-container'),
  //                     interfaceConfigOverwrite: {
  //                         filmStripOnly: false,
  //                         SHOW_JITSI_WATERMARK: false,
  //                         SHOW_WATERMARK_FOR_GUESTS: false,
  //                     },
  //                     configOverwrite: {
  //                             disableSimulcast: false,
  //                     },
  //                 };

  //                 this.api = new JitsiMeetExternalAPI(domain, options);
                  
  //                 this.api.addEventListener('videoConferenceJoined', () => {
  //                     console.log('Local User Joined');
  //                     _this.api.executeCommand('displayName', _this.username);
  //                     _this.api.executeCommand('setVideoQuality', 480);
  //                 });
  //                 this.api.addEventListener('readyToClose', () => {
  //                     _this.closeMeeting();
  //                 });
  //                 this.api.executeCommand('password',_this.pass);

  //             } catch (error) {
  //                 console.error('Failed to load Paaralan API', error);
  //             }
  //     },

  //     closeMeeting(){
  //         //this method properly closes the meeting. Offload the API as per documentation
  //         this.api.dispose();
  //         this.closeMeetingRoom = true;
  //         this.$router.push('dashboard');
  //     },

  //     openRoom(){
  //         // verify the JitsiMeetExternalAPI constructor is added to the global..
  //         if (window.JitsiMeetExternalAPI) {
  //         //     var person = prompt("Please enter your name:", "test");
  //         // if (person != null || person != "") 
  //         //     this.username=person
  //         //     var room = prompt("Please enter your room:", "student-test");
  //         // if (room != null || room != "") 
  //             // this.room=room
  //             this.startConference();
  //         }
  //         else alert('Learn With Me Live Stream script not loaded');
  //         }
                  
  // }
}
</script>