<template>
    <section class="content">
        <div class="container-fluid">
            <!--new row-->
            <div class="row">
                <section id="instructions" class="col-12 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">{{ classDet.title }}</div>
                        <div class="card-body">
                            <div
                                class="media flex-column flex-md-row align-items-center align-items-md-start"
                            >
                                <img
                                    v-if="classDet.teacher"
                                    :src="classDet.teacher.avatar_url"
                                    :alt="classDet.teacher.name"
                                    class="mb-3 mr-md-3 rounded-circle teacher-avatar"
                                />
                                <div class="media-body">
                                    <h4 class="mt-0 text-center text-md-left">
                                        Good morning {{ pupil.firstName }}
                                    </h4>
                                    <p>
                                        <strong>Instructions:</strong>
                                        {{ classDet.instruction }}
                                    </p>
                                </div>
                            </div>
                            <!-- video-->
                            <div
                                class="embed-responsive embed-responsive-16by9"
                                v-if="classDet.videoPrev"
                            >
                                <iframe
                                    :src="classDet.videoLink"
                                    allowfullscreen="allowfullscreen"
                                    class="embed-responsive-item"
                                ></iframe>
                            </div>
                            <!--/video-->

                            <!--RICH TEXT-->
                            <div id="text" class="mt-4">
                                <p v-html="classDet.content"></p>
                            </div>
                            <!--END RICH TEXT-->

                            <!--documents-->
                            <div
                                id="documents"
                                class="mt-4"
                                v-if="docCount > 0"
                            >
                                <h6>Please open these documents</h6>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a href="#"
                                            ><i class="icon doc doc-lg"></i
                                            >Worksheet 1</a
                                        >
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#"
                                            ><i class="icon pdf pdf-lg"></i
                                            >Worksheet 2</a
                                        >
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#"
                                            ><i class="icon pdf pdf-lg"></i
                                            >Worksheet 3</a
                                        >
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#"
                                            ><i class="icon pdf pdf-lg"></i
                                            >Worksheet 4</a
                                        >
                                    </li>
                                </ul>
                            </div>
                            <!--end documents-->
                            <!--images-->
                            <div id="images" class="mt-4" v-if="fileCount > 0">
                                <img
                                    src="https://placeimg.com/800/600/any"
                                    class="img-fluid"
                                    alt="worksheet"
                                />
                            </div>
                            <!--/images-->
                        </div>
                    </div>
                </section>

                <section id="workarea" class="col-12 col-md-6 mb-4">
                    <div class="card sticky-top">
                        <div class="card-body">
                            <router-link :to="{ name: 'dashboard' }" class="btn btn-dark btn-block"> Return to Dashboard </router-link>
                            <form id="submission" class="mt-4">
                                <div class="form-group">
                                    <label for="submissions"
                                        >Pupil, please type your answers
                                        here</label
                                    >
                                    <textarea
                                        id="submissions"
                                        class="form-control form-control-lg textarea-autosize"
                                        v-model="answer.answer"
                                        placeholder="Start typing..."
                                    ></textarea>
                                </div>
                                <div class="form-group">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                    >
                                        Attach work
                                    </button>
                                </div>
                                <div class="form-group">
                                    <p class="text-center">
                                        Check your work before you click submit
                                    </p>
                                    <button
                                        type="button"
                                        class="btn btn-success btn-block btn-lg"
                                        @click="submitMyWork"
                                    >
                                        Submit my work
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <!--/end row-->
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            classDet: {},
            docCount: 0,
            fileCount: 0,
            pupil: {},
            student: {},
            answer: {},
            media: [],
            text: ""
        };
    },

    mounted() {
        // check and get the student class by id
        this.onInit();
    },

    methods: {
        onInit() {
            if (this.$route.query.class_id) {
                let class_id = this.$route.query.class_id;
                this.getStudentClass(class_id);
            } else {
                return this.$router.push({ name: "dashboard" });
            }

            this.getPupilInfo();
        },

        getStudentClass(class_id) {
            //this method extracts the student answer and any attached media
            axios
                .post("/api/getStudentClassByID", { classID: class_id })
                .then(res => {
                    console.log("answers=", res);
                    this.classDet = res.data.classDet;

                    let allImages = res.data.allMedia;
                    let allDocs = res.data.allDocs;

                    this.classDet.allImages = allImages;
                    this.classDet.allDocs = allDocs;

                    if (this.classDet.videoLink != "") {
                        this.classDet.videoPrev = true;
                    }
                })
                .catch(err => {
                    console.log("get-answ-err", err);
                });
        },

        getTecherInfo() {
            //this method gets the teacher info to display the avatar and the teacher name
        },

        submitMyWork() {
            this.answer.class_id = this.classDet.id;
            this.answer.teacher_id = this.classDet.teacher_id;
            this.answer.student_id = this.pupil.id;
            this.$axios
                .post("/api/setStudentAnswer", this.answer, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                        // 'Content-type' : 'multipart/form-data; charset=utf-8; boundary=' + Math.random().toString().substr(2)
                    }
                })
                .then(res => {
                    console.log("answer-", res);
                    this.media = res.data.media;
                })
                .catch(err => {
                    console.log("answer-err", err);
                });

            this.retDash();
        },

        getPupilInfo() {
            // this method pulls the information about the pupil
            //find the current user - assume its the pupil
            axios
                .get("/api/getStudentProfile")
                .then(res => {
                    this.pupil = res.data.student;
                    console.log("user-data", this.pupil);
                    console.log("user-data", res);
                    this.student.id = res.data.student.id;
                    this.getClassInfo().then(() => {
                        this.getStudentAnswer();
                    });
                })
                .catch(err => {
                    console.log("err-get-pupil", err);
                });
        },

        getStudentAnswer() {
            //this method extracts the student answer and any attached media
            this.answer.class_id = this.classDet.id;
            this.answer.student_id = this.pupil.id;
            this.answer.teacher_id = this.classDet.teacher_id;
            this.$axios
                .post("/api/getStudentAnswer", this.answer)
                .then(res => {
                    console.log("answers=", res);
                    this.answer = res.data.answer;
                    this.media = res.data.media;
                })
                .catch(err => {
                    console.log("get-answ-err", err);
                });
        },

        getClassInfo() {
            //this method pulls all the data with regards to the class being opened
            let x = this.$axios
                .post("/api/getClassById", {
                    classID: this.$store.state.classID
                })
                .then(res => {
                    console.log("get-class-edit", res);
                    this.classDet = res.data.classDet;
                    this.classDet.allImages = res.data.allMedia;
                    this.$store.dispatch("setClassID", null);
                    if (this.classDet.content != null) {
                        this.openTextBox = 1;
                    }
                    if (this.classDet.videoLink != "") {
                        this.classDet.videoPrev = true;
                        this.videoCount = 1;
                    }
                    if (res.data.allMedia.length > 0) {
                        this.showImages = true;
                        this.fileCount = res.data.allMedia.length;
                    }
                    if (res.data.allDocs.length > 0) {
                        this.docCount = res.data.allDocs.length;
                    }
                    if (res.data.teacher_id > 0) {
                        this.getTeacherInfo();
                    }
                    return res.data.classDet;
                })
                .catch(err => {
                    console.log("class-det-err", err);
                    return err;
                });

            return x;
        }
    }
};
</script>

<style>
.teacher-avatar {
    width: 4.2em;
    height: 4.2em;
}
</style>
