<template>
    <div>
        <section class="content">
            <div class="content__inner">
                <div class="row">
                    <div class="col-12">
                        <flash-message />
                        <section id="dashboard-buttons">
                            <!-- <a href="teachers-create.php" class="btn btn-primary btn-lg max-for-mobile">Create New Class</a> -->
                            <div
                                class="btn btn-primary btn-lg max-for-mobile"
                                @click="createNewClass"
                            >
                                Create New Class
                            </div>
                            <!-- <a href="quiz-create.php" class="btn btn-warning btn-lg max-for-mobile">Create New Quiz</a> -->
                            <router-link
                                to="/QuizCreate"
                                class="btn btn-warning btn-lg max-for-mobile"
                                >Create New Quiz</router-link
                            >
                            <!-- <a href="teachers-schedule-live-class.php" class="btn btn-success btn-lg max-for-mobile">Schedule Live Class</a> -->
                            <router-link
                                to="/liveStreamSchedule"
                                class="btn btn-success btn-lg max-for-mobile"
                                >Schedule Live Class</router-link
                            >
                            <router-link
                                to="/Admin"
                                class="btn btn-lg max-for-mobile float-right"
                            ></router-link>
                        </section>
                        
                        <section
                            id="reminder"
                            class="mt-4"
                            v-if="reminderLiveStream"
                        >
                            <div class="alert alert-primary" role="alert">
                                You have a live class starting in 27 mins
                                <a
                                    href="#"
                                    @click="goLiveSchedule"
                                    class="btn btn-primary max-for-mobile"
                                    >Go to live classroom</a
                                >
                            </div>
                        </section>
                        
                        <section id="teachertables" class="card mt-4">
                            <div>
                                <b-card no-body>
                                    <b-tabs pills card>
                                        <b-tab title="Marking" active>
                                            <b-card-text>
                                                <table
                                                    class="table table-striped table-bordered"
                                                >
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                scope="col"
                                                                class="d-none d-md-table-cell"
                                                            >
                                                                Subject
                                                            </th>
                                                            <th scope="col">
                                                                Name
                                                            </th>
                                                            <th scope="col">
                                                                Mark
                                                            </th>
                                                            <th
                                                                scope="col"
                                                                class="d-none d-md-table-cell"
                                                            >
                                                                Started
                                                            </th>
                                                            <th
                                                                scope="col"
                                                                class="d-none d-md-table-cell"
                                                            >
                                                                Ending
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <Techclass
                                                            v-for="item in classes"
                                                            :key="item.id"
                                                            :data="item"
                                                        />
                                                    </tbody>
                                                </table>
                                            </b-card-text>
                                        </b-tab>
                                        <b-tab title="To do list">
                                            <b-card-text
                                                >To do list table goes
                                                here</b-card-text
                                            >
                                        </b-tab>
                                    </b-tabs>
                                </b-card>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Techclass from "../components/Techclass.vue";

export default {
    components: {
        Techclass
    },
    computed: {},
    data() {
        return {
            userInfo: {},
            reminderLiveStream: false,
            classes: [],
            classesDraft: []
        };
    },
    // mounted(){
    //     this.onInit()
    // },

    methods: {
        createNewClass() {
            //this method creates a new class

            //this.$store.dispatch('setClassID','');
            this.$router.push({ name: "create-class" });
        },
        onInit() {
            //This api is to get live class
            // this.$axios.get('/api/getTeacherClasses',{
            //    headers: {
            //         'X-Requested-With' : 'XMLHttpRequest',
            //         'Content-Type': 'multipart/form-data'
            //     },
            //     withCredentials: true,
            // })
            // .then(response => {
            //     console.log('res-data',response);
            //     response.data.classDrafts.forEach(element => {
            //          let x = {
            //             id: element.id,
            //             subject: element.subject.title,
            //             title: element.title,
            //             startDate: element.startDate,
            //             submissionDate: element.submissionDate,
            //          }
            //          this.classesDraft.push(x);
            //       });
            //     response.data.classMarking.forEach(element => {
            //          let x = {
            //             id: element.id,
            //             subject: element.subject.title,
            //             title: element.title,
            //             startDate: element.startDate,
            //             submissionDate: element.submissionDate,
            //          }
            //          this.classes.push(x);
            //       });
            // }).catch(err=>{
            //     if(err.message == 'Unauthenticated'){
            //         this.flash('Your session has ended.  You will be logged out. Please login again to use the System','warning');
            //         this.$store.dispatch('logout');
            //     }
            // })
        },

        goLiveSchedule() {
            this.$router.push("liveStreamSchedule");
        }
    }
};
</script>

<style scoped></style>
