<template>
  <div>
    <section class="content">
      <div class="content__inner">
        <div class="row">
          <div class="col-12">
            <!-- <a href="teachers-create.php" class="btn btn-primary btn-lg mb-4">Create New Class</a> -->
            <!-- <router-link to="/createClass" class="btn btn-primary btn-lg max-for-mobile mb-4">Create New Class</router-link> -->
            <div class="btn btn-primary btn-lg max-for-mobile mb-4" @click="createNewClass">Create New Class</div>
            <b-card no-body>
              <b-tabs pills card>
                <b-tab title="Active">
                  <b-card-text>
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th scope="col" class="d-none d-md-table-cell">Subject</th>
                          <th scope="col">Name</th>
                          <th scope="col" class="d-none d-md-table-cell">Started</th>
                          <th scope="col" class="d-none d-md-table-cell">Ending</th>
                        </tr>
                      </thead>
                      <tbody>
                        <listclass v-for="item in  classesActive" :key="item.id" :data="item"/>
                      </tbody>
                    </table>
                  </b-card-text>
                </b-tab>

                <b-tab title="Marking">
                  <b-card-text>
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th scope="col" class="d-none d-md-table-cell">Subject</th>
                          <th scope="col">Name</th>
                          <th scope="col">Mark Class</th>
                          <th scope="col" class="d-none d-md-table-cell">Started</th>
                          <th scope="col" class="d-none d-md-table-cell">Ending</th>
                        </tr>
                      </thead>
                      <tbody>
                        <Techclass v-for="item in classesMarking" :key="item.id" :data="item"/>
                      </tbody>
                    </table>
                  </b-card-text>
                </b-tab>

                <b-tab title="Scheduled">
                  <b-card-text>
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th scope="col" class="d-none d-md-table-cell">Subject</th>
                          <th scope="col">Name</th>
                          <th scope="col" class="d-none d-md-table-cell">Started</th>
                          <th scope="col" class="d-none d-md-table-cell">Ending</th>
                        </tr>
                      </thead>
                      <tbody>
                        <listclass v-for="item in classes" :key="item.id" :data="item"/>
                      </tbody>
                    </table>
                  </b-card-text>
                </b-tab>

                <b-tab title="Drafts">
                  <b-card-text>
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th scope="col" class="d-none d-md-table-cell">Subject</th>
                          <th scope="col">Name</th>
                          <th scope="col" class="d-none d-md-table-cell">Started</th>
                          <th scope="col" class="d-none d-md-table-cell">Ending</th>
                        </tr>
                      </thead>
                      <tbody>
                        <listclass v-for="item in classesDraft" :key="item.id" :data="item"/>
                      </tbody>
                    </table>
                  </b-card-text>
                </b-tab>

                <b-tab title="Completed">
                  <b-card-text>
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th scope="col" class="d-none d-md-table-cell">Subject</th>
                          <th scope="col">Name</th>
                          <th scope="col" class="d-none d-md-table-cell">Started</th>
                          <th scope="col" class="d-none d-md-table-cell">Ending</th>
                          <th scope="col">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <Techclass v-for="item in classesCompleted" :key="item.id" :data="item"/>
                      </tbody>
                    </table>
                  </b-card-text>
                </b-tab>
              </b-tabs>
            </b-card>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Techclass from '../components/Techclass.vue';
import listclass from '../components/listclass.vue';
  
  export default {
    components:{
        Techclass,
        listclass,
    },

    data(){
        return{
          classes:[
              // {id:'',classname:'',subject:''},
          ],

          classesCompleted: [],
          classesDraft: [],
          classesActive: [],
          classesMarking: [],
          formData: [],
        }
        
    },

    mounted() {
      this.onInit();
    },

    methods:{
        onInit() {//This api is to get live class
          axios.get('/api/getClassesByTeacher')
          .then(response=>{
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

               response.data.classActive.forEach(element => {
                    let x = {
                       id: element.id,
                       subject: element.subject.title,
                       title: element.title,
                       startDate: element.startDate,
                       submissionDate: element.submissionDate,
                    }
                    this.classesActive.push(x);
                 });
              
              response.data.classCompleted.forEach(element => {
                    let x = {
                      id: element.id,
                      subject: element.subject.title,
                      title: element.title,
                      startDate: element.startDate,
                      submissionDate: element.submissionDate,
                    }
                    this.classesCompleted.push(x);
                });

              response.data.classMarking.forEach(element => {
                    let x = {
                      id: element.id,
                      subject: element.subject.title,
                      title: element.title,
                      startDate: element.startDate,
                      submissionDate: element.submissionDate,
                    }
                    this.classesMarking.push(x);
                });
          }).catch(err=>{
              if(err.message.includes('401')){
                //unauthorized access was returned,  gat timed out so logout user
                console.log('logging out');
                this.$store.dispatch('logout')
              }else{
                console.log('err-lookup',err);
              }
          })
        },

        createNewClass(){
          //this method creates a new class
          this.$router.push({name: 'create-class'});
        },
    }

  }
</script>
