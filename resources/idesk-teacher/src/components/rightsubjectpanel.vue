<template>
    <section id="settings" class="col-12 col-md-4">
        <div class="card sticky-top">
            <div class="card-body">
                <form action="">
                    <b-form-select
                        v-model="classDet.subject_id"
                        :options="options"
                        class="mb-3"
                    ></b-form-select>
                    <div class="draft-feedback form-group">
                        <button
                            type="button"
                            class="btn btn-secondary btn-block"
                            @click="onDraft"
                        >
                            Save for Later
                        </button>

                        <div v-if="draftAvailable" class="col-12 mt-2 mb-2 badge badge-success">
                           Last saved <timeago :datetime="classDraft.updated_at" :auto-update="60"></timeago>
                        </div>

                        <!-- <div class="alert-wrapper">
                            <div class="alert alert-success" role="alert">
                                Saved as draft
                            </div>
                        </div> -->
                    </div>
                    <div class="form-group">
                        <label for="startdate">Start date of {{ classDet.title }}</label>
                        <b-form-datepicker
                            id="startDate"
                            v-model="classDet.startDate"
                            class="mb-2"
                        ></b-form-datepicker>
                    </div>
                    <div class="form-group">
                        <label for="endDate"
                            >End date of {{ classDet.title }}</label
                        >
                        <b-form-datepicker
                            id="endDate"
                            v-model="classDet.submissionDate"
                            class="mb-2"
                        ></b-form-datepicker>
                    </div>
                    <div class="class-contents">
                        <h6>Your class includes:</h6>
                        <ul class="list-group list-group-flush">
                            <li v-show="docCount > 0" class="list-group-item justify-content-between doc">
                              <div>
                                 <span class="badge badge-info mr-2">x{{ docCount }}</span>Document(s)
                              </div> 
                              <span class="icon doc"></span>
                           </li>
                            
                            <li v-show="videoCount > 0" class="list-group-item justify-content-between youtube">
                              <div>
                                 <span class="badge badge-danger mr-2">x{{ videoCount }}</span>YouTube link
                              </div> 
                              <span class="icon youtube"></span>
                           </li>

                           <li v-show="fileCount > 0" class="list-group-item justify-content-between images">
                              <div>
                                 <span class="badge badge-success mr-2">x{{ fileCount }}</span>Images
                              </div> 
                              <span class="icon images"></span>
                           </li>
                        </ul>
                    </div>
                    <button
                        type="button"
                        class="btn btn-success btn-lg btn-block"
                        @click="onSchedule"
                    >
                        {{ scheduling ? '' : buttonText }} <i v-show="scheduling" class="fa fa-spinner fa-spin"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: {
       buttonText: {
          type: String
       },

        classObj: {
            type: Object
        },

        classDraft: {}
    },

    data() {
        return {
            classDet: {},

            docCount: 0,
            videoCount: 0,
            fileCount: 0,
            options: [{ value: 0, text: "Please select a subject" }],
            scheduling: false
        };
    },

    computed: {
       draftAvailable: function() {
         return Object.keys(this.classDraft).length > 0;
      }
    },

    mounted() {
        this.classDet = this.classObj;
        this.getSubject();
    },

    watch: {
        "classObj.title": function() {
            this.classDet = this.classObj;
            this.fileCount = this.classDet.allImages.length;
            this.docCount = this.classDet.allDocs.length;

            if (this.classDet.videoLink != "") {
                this.videoCount = 1;
                this.classDet.videoPrev = true;
            }
        },
        "classObj.instruction": function() {
            this.classDet = this.classObj;
        },
        "classObj.allImages": function() {
            this.classDet = this.classObj;
            this.fileCount = this.classObj.allImages.length;
        },
        "classObj.allDocs": function() {
           this.classDet = this.classObj;
           this.docCount = this.classObj.allDocs.length;
        }
    },

    methods: {
        getClass() {
            if (this.$store.state.classID != null) {
                axios
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
                        if (this.classDet.videoLink != null) {
                            this.classDet.videoPrev;
                            this.videoCount = 1;
                        }
                        if (res.data.allMedia.length > 0) {
                            this.showImages = true;
                            this.fileCount = res.data.allMedia.length;
                        }
                        if (res.data.allDocs.length > 0) {
                            this.docCount = res.data.allDocs.length;
                        }
                    })
                    .catch(err => {
                        console.log("class-det-err", err);
                    });
            }
        },

        getSubject() {
            //This method is to get subject name from db
            axios.get("/api/getSubjects").then(response => {
                console.log("subjects-get", response);
                response.data.subjects.forEach(element => {
                    let x = {
                        value: element.id,
                        text: element.title
                    };
                    this.options.push(x);
                });
            });
        },

        onSchedule() {
            //this method is used to save the details above
            if (this.classDet.subject_id > 0) {
                this.classDet.status = "Scheduled";
                this.scheduling = true;

                axios
                    .post("/api/updateClassDet", this.classDet)
                    .then(res => {
                        console.log("save-sched", res);
                        this.scheduling = false;
                        
                        this.flashMessage.show({
                            status: "success",
                            icon: "/images/icon-success.svg",
                            blockClass: "flash_message",
                            title: "Success",
                            message: "Your class was saved as Scheduled"
                        });

                        this.classDet = res.data.classes;
                        this.$router.push({name: "my-classes"});
                    })
                    .catch(err => {
                       this.scheduling = false;

                        this.flashMessage.show({
                            status: "error",
                            icon: "/images/icon-error.svg",
                            blockClass: "flash_message",
                            title: "Error",
                            message: "An Error Occured whilst saving this Class"
                        });
                        console.log("save-draft-err", err);
                    });
            } else {
                this.flashMessage.show({
                    status: "warning",
                    icon: "/images/icon-warning.svg",
                    blockClass: "flash_message",
                    title: "Warning",
                    message:
                        "Please select a SUBJECT for this Class.  This class WAS NOT SAVED"
                });
            }
        },

        onDraft() {
            //This api is to save draft class - check first if a subject is defined
            if (this.classDet.subject_id > 0) {
                this.classDet.files = [];

                this.classDet.status = "Draft";

                let images = [];
                let docs = [];

                let formData = new FormData();
                let headers = { "Content-Type": "multipart/form-data" };

                formData.append("id", this.classDet.id);
                formData.append("subject_id", this.classDet.subject_id);
                formData.append("title", this.classDet.title);
                formData.append("instruction", this.classDet.instruction);
                formData.append("content", this.classDet.content);
                formData.append("status", this.classDet.status);
                formData.append("videoLink", this.classDet.videoLink);
                formData.append("startDate", this.classDet.startDate);
                formData.append("submissionDate", this.classDet.submissionDate);
                formData.append("gradeLevel_id", this.classDet.gradeLevel_id);

                for (let i = 0; i < this.classDet.allImages.length; i++) {
                    if (this.classDet.allImages[i].uploaded == 0) {
                        alert(this.classDet.allImages[i].name)
                        images.push(this.classDet.allImages[i].file);   
                    }        
                }

                if (images.length > 0) {
                    for (let i = 0; i < images.length; i++) {
                        formData.append("images[]", images[i]);
                    }
                }
                
                axios
                    .post("/api/updateClassDet", formData, { headers })
                    .then(res => {
                        console.log("save-draft", res);

                        this.flashMessage.show({
                            status: "success",
                            icon: "/images/icon-success.svg",
                            blockClass: "flash_message",
                            title: "Success",
                            message: "Your Class was saved Successfully!"
                        });

                        this.classDet = res.data.classes;
                        this.$emit("classUpdated", this.classDet);
                    })
                    .catch(err => {
                        this.flashMessage.show({
                            status: "warning",
                            icon: "/images/icon-warning.svg",
                            blockClass: "flash_message",
                            title: "Warning",
                            message:
                                "An Error Occured whilst saving this Class!"
                        });
                        console.log("save-draft-err", err);
                    });
                return true;
            } else {
                this.flashMessage.show({
                    status: "warning",
                    icon: "/images/icon-warning.svg",
                    blockClass: "flash_message",
                    title: "Warning",
                    message:
                        "Plese Select a subject! - this class was not saved!!"
                });
                return false;
            }
        }
    }
};
</script>
