<template>
    <section class="content">
        <div class="container-fluid">
            <!--new row-->
            <div class="row">
                <!--grading area-->
                <section id="grading-area" class="col-lg-8 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <!--start feedback area-->
                            <div id="feedback" class="card mt-2">
                                <div class="card-body">
                                    <form>
                                        <div class="form-group">
                                            <textarea
                                                id="teachers-feedback"
                                                v-model="ansDetail.feedback"
                                                class="form-control form-control-lg textarea-autosize"
                                                placeholder="Start typing feedback..."
                                                style=""
                                            ></textarea>
                                        </div>
                                        <div class="form-group mb-0">
                                            <ul
                                                class="nav nav-pills nav-fill grading-options"
                                            >
                                                <li class="nav-item">
                                                    <a
                                                        :class="
                                                            'nav-link Grade-5 ' +
                                                                setActive[4]
                                                        "
                                                        @click="setGrade(5)"
                                                        >Poor effort</a
                                                    >
                                                </li>
                                                <li class="nav-item">
                                                    <a
                                                        :class="
                                                            'nav-link Grade-4 ' +
                                                                setActive[3]
                                                        "
                                                        @click="setGrade(4)"
                                                        >More effort required</a
                                                    >
                                                </li>
                                                <li class="nav-item">
                                                    <a
                                                        :class="
                                                            'nav-link Grade-3 ' +
                                                                setActive[2]
                                                        "
                                                        @click="setGrade(3)"
                                                        >Can do better</a
                                                    >
                                                </li>
                                                <li class="nav-item">
                                                    <a
                                                        :class="
                                                            'nav-link Grade-2 ' +
                                                                setActive[1]
                                                        "
                                                        @click="setGrade(2)"
                                                        >Good work</a
                                                    >
                                                </li>
                                                <li class="nav-item">
                                                    <a
                                                        :class="
                                                            'nav-link Grade-1 ' +
                                                                setActive[0]
                                                        "
                                                        @click="setGrade(1)"
                                                        >Excellent</a
                                                    >
                                                </li>
                                            </ul>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--end feedback area-->

                            <div id="submissions" class="card mt-2">
                                <div
                                    class="card-header d-flex justify-content-between align-items-center"
                                >
                                    <div>
                                        <span
                                            class="badge badge-pill badge-primary mr-1 hide-for-small-only"
                                            >{{ classDet.title }}</span
                                        >
                                        <span
                                            class="badge badge-pill badge-secondary hide-for-small-only"
                                            >{{
                                                ansDetail.student.firstName
                                            }}
                                            submitted:
                                            <timeago :datetime="ansDetail.dateAnswer" :auto-update="60"></timeago>
                                          </span
                                        >
                                    </div>
                                    <!--attachments area-->
                                    <div
                                        class="attachments d-flex justify-content-between align-items-center"
                                    >
                                        <small class="show-for-small-only mr-3"
                                            >Attachments</small
                                        >
                                        <a href="#">
                                            <i class="icon pdf"></i>
                                        </a>
                                        <a href="#">
                                            <i class="icon doc"></i>
                                        </a>
                                    </div>
                                    <!--end attachments-->
                                </div>

                                <div class="card-body overflow-auto">
                                    <!--echo pupils.submissions.text-->
                                    <ol>
                                        <!-- <p v-html="ansDetail.answer"></p> -->
                                        <annotate :contentText="ansDetail.answer" />
                                    </ol>
                                    <!--end pupils.submission.text-->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--end grading-->
                
                <!--pupils list-->
                <section id="pupils-list" class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <button
                                type="button"
                                class="btn btn-block btn-lg btn-success"
                                @click="sendFeedback"
                            >
                                Send Feedback
                            </button>
                            <div class="list-group mt-3">
                                <div v-for="st in studentList" :key="st.id">
                                    <a
                                        href="#"
                                        class="list-group-item list-group-item-action d-flex justify-content-between"
                                        :class="{'active': true}"
                                        @click="pickAnswer(st.id)"
                                        ><span class="user-in-table">{{
                                            st.firstName
                                        }}</span> <span class="badge Grade-2 h-100">Good work</span></a>
                                </div>
                                <!-- <a href="#" class="list-group-item list-group-item-action  d-flex justify-content-between"><span class="user-in-table">Simon</span></a>
                  <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between"><span class="user-in-table">Henry Short</span><span class="badge Grade-2 h-100">Good work</span></a>
                  <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between"><span class="user-in-table">Prabha Surtraramen</span><span class="badge Grade-4 h-100">More effort required</span></a> -->
                            </div>
                        </div>
                    </div>
                </section>
                <!--end pupils list-->
                <!--/end row-->
            </div>
        </div>
    </section>
</template>

<script>
import annotate from '../components/annotate.vue';

export default {
    components: {
      annotate
    },

    data() {
        return {
            classx: {},
            classDet: {},
            answers: [],
            media: [],

            ansDetail: {
                answer: "",
                feedback: "",
                
                student: {
                    firstName: "",
                    lastName: ""
                },

                dateFeedback: null,
                feedbackbyTeacher_id: 0,
                mark: "",
                markValue: 0
            },

            studentList: [],

            gradeLevel: [
                {
                    grade: "Grade-1",
                    text: "Excellent"
                },
                {
                    grade: "Grade-2",
                    text: "Good Work"
                },
                {
                    grade: "Grade-3",
                    text: "Can do better"
                },
                {
                    grade: "Grade-4",
                    text: "More effort required"
                },
                {
                    grade: "Grade-5",
                    text: "Poor effort"
                }
            ],

            setActive: ["", "", "", "", ""]
        };
    },

    mounted() {
      this.onInit();
      this.flashMessage.setStrategy("multiple");
    },

    methods: {
       onInit() {
            if (this.$route.query.class_id) {
                let class_id = this.$route.query.class_id;
                this.getClassById(class_id);
            } else {
               return this.$router.push({name: "my-classes"});
            }
        },

        getClassById(class_id) {
            axios
                .post("/api/getClassById", { classID: class_id })
                .then(response => {
                    console.log("get-class-edit", response);
                    this.buttonText = "Save Changes";
                    let classDet = response.data.classDet;

                    let allImages = response.data.allMedia;
                    let allDocs = response.data.allDocs;

                    this.classDet.id = classDet.id;
                    this.classDet.title = classDet.title;
                    this.classDet.instruction = classDet.instruction;
                    this.classDet.content = classDet.content;
                    this.classDet.startDate = classDet.startDate;
                    this.classDet.subject_id = classDet.subject_id;
                    this.classDet.submissionDate = classDet.submissionDate;
                    this.classDet.videoLink = classDet.videoLink;

                    this.classDet.allImages = allImages;
                    this.classDet.allDocs = allDocs;

                    if (this.classDet.content != null) {
                        this.openTextBox = 1;
                    }
                    if (this.classDet.videoLink != "") {
                        //This method is to preview youtube
                        var video_id = this.classDet.videoLink.split(
                            "/embed/"
                        )[1];
                        var ampersandPosition = video_id.indexOf("&");
                        console.log("video id", video_id, ampersandPosition);

                        if (ampersandPosition != -1) {
                            video_id = video_id.substring(0, ampersandPosition);
                        }

                        this.classDet.videoID = video_id;

                        // var api_key = "AIzaSyCswgVQLyUOuoLIMbEbsPdUR680G_LC1PE";
                        // var querystring = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&id=' + video_id + '&key='+api_key;
                        axios
                            .post("/api/getYouTubeInfo", { videoID: video_id })
                            .then(response => {
                                console.log("video-res", response);

                                this.classDet.videoPreview = true;
                                this.classDet.videoThumb =
                                    response.data.items[0].snippet.thumbnails.default.url;
                                this.classDet.videoTitle =
                                    response.data.items[0].snippet.title;
                                this.classDet.videoDesc =
                                    response.data.items[0].snippet.description;

                                this.classDet.videoPreview = true;
                                this.videoCount = 1;
                            })
                            .catch(error => {
                                console.log(error);
                            });

                        this.classDet.videoPrev = true;
                        this.videoCount = 1;
                    }

                    if (this.classDet.allImages.length > 0) {
                        this.showImages = true;
                        this.fileCount = this.classDet.allImages.length;
                    }

                    if (this.classDet.allDocs.length > 0) {
                        this.docCount = this.classDet.allDocs.length;
                    }

                    this.getStudentAnswer();
                })
                .catch(err => {
                    console.log("class-det-err:", err.response);

                    this.flashMessage.show({
                        status: "error",
                        icon: "/images/icon-error.svg",
                        blockClass: "flash_message",
                        title: "Error",
                        message: err.response.data.message
                    });

                    let vm = this;

                    setTimeout(function() {
                        vm.$router.push({ name: "my-classes" });
                    }, 10000);
                });
        },

        pickAnswer(id) {
            //this module will assing the details to the picked answer
            console.log("ans", this.answers[id], id);
            //  this.ansDetail = JSON.parse(JSON.stringify(this.answers[id]));
            
            this.answers.forEach(element => {
                if (element.id == id) {
                  this.ansDetail = element;
                }
            });

            this.setActive = ["", "", "", "", ""];
            this.setActive[this.ansDetail.markValue - 1] = "active";
            this.ansDetail.dateFeedback = new Date()
                .toJSON()
                .slice(0, 19)
                .replace("T", " ");
            
            //this.ansDetail.feedbackbyTeacher_id = this.user.id;
        },

        setGrade(gr) {
            //this module will store the grade level on the detail
            this.ansDetail.mark = this.gradeLevel[gr - 1].text;
            this.ansDetail.markValue = gr;
            this.setActive = ["", "", "", "", ""];
            this.setActive[gr - 1] = "active";
        },

        sendFeedback() {
            //this method saves all the entries of the list of marks
            axios
                .put("/api/setFeedback", this.answers)
                .then(res => {
                   this.flashMessage.show({
                     status: "success",
                     icon: "/images/icon-success.svg",
                     blockClass: "flash_message",
                     title: "Success",
                     message: "Feedback has been saved"
                  });

                    console.log("feedback-ret", res.data.feedback);
                })
                .catch(err => {
                   this.flashMessage.show({
                     status: "error",
                     icon: "/images/icon-error.svg",
                     blockClass: "flash_message",
                     title: "Error",
                     message: "Something went wrong!"
                  });

                    console.log("feedback-ret-err", err);
                });
        },

        getStudentAnswer() {
            //this method extracts the student answer and any attached media
            let classID = this.classDet.id;
            //let teacherID = this.classDet.teacher_id;

            axios
                .post("/api/getAnswrByClass", {
                    withCredentials: true,
                    class_id: classID
                })
                .then(res => {
                    console.log("answers=", res);
                    res.data.answers.forEach(element => {
                        // if(element.student == []){
                        //     let x = {
                        //         id : element.id,
                        //         firstName: 'Missing',
                        //         lastName: 'Missing'
                        //     };
                        // }else{
                        let x = {
                            id: element.id,
                            firstName: element.student.firstName,
                            lastName: element.student.lastName
                        };
                        // }
                        this.answers.push(element);
                        this.studentList.push(x);

                        // Set the first answer
                        if (this.studentList.length > 0) {
                           this.pickAnswer(this.studentList[0].id)
                        }
                    });
                })
                .catch(err => {
                    console.log("get-answ-err", err);
                });
        }
    }
};
</script>
