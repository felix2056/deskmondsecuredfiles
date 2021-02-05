<template>
    <section class="content">
        <div class="content__inner">
            <div class="row">
                <section id="create" class="col-12 col-md-8">
                    <div class="card">
                        <div :id="'subject-banner ' + options[0]['text']"></div>
                        <div class="card-body">
                            <div
                                v-if="draftAvailable"
                                class="alert alert-warning"
                            >
                                <span class="fa fa-exclamation-triangle"></span>
                                You have a draft waiting to be finished!
                                <button
                                    @click="loadDraft"
                                    type="button"
                                    class="btn btn-success"
                                >
                                    Load Draft
                                </button>
                            </div>

                            <form>
                                <div class="form-group">
                                    <label for="title">Class name</label>
                                    <input
                                        type="text"
                                        id="title"
                                        class="form-control form-control-lg"
                                        placeholder="Example: The Water Cycle"
                                        v-model="classDet.title"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="instructions">
                                        Instructions for pupils
                                    </label>

                                    <b-form-textarea
                                        id="textarea"
                                        class="textarea-autosize"
                                        v-model="classDet.instruction"
                                        placeholder="Start typing ..."
                                        rows="3"
                                        max-rows="6"
                                    />
                                </div>

                                <div>
                                    <b-dropdown
                                        class="md-2"
                                        id="addmedia"
                                        variant="primary"
                                        text="Add media"
                                        size="lg"
                                    >
                                        <b-dropdown-item v-b-modal.AddYouTube
                                            >YouTube Link</b-dropdown-item
                                        >
                                        <b-dropdown-item v-b-modal.AddImages
                                            >Images</b-dropdown-item
                                        >
                                        <b-dropdown-item v-b-modal.AddDocument
                                            >File</b-dropdown-item
                                        >
                                        <b-dropdown-item
                                            @click="openTextBox = !openTextBox"
                                            >Rich Text</b-dropdown-item
                                        >
                                    </b-dropdown>
                                </div>
                            </form>

                            <!-- Quill Editor -->
                            <div
                                id="text"
                                class="form-group"
                                v-if="openTextBox"
                            >
                                <div class="card-title">Text</div>
                                <div class="actions">
                                    <button
                                        class="btn btn-light"
                                        @click="deleteTextBox"
                                    >
                                        <i class="icon trash"></i>
                                    </button>
                                </div>
                                <div class="mt-4">
                                    <quill-editor
                                        ref="editor"
                                        v-model="classDet.content"
                                        :options="editorOption"
                                        @blur="onEditorBlur($event)"
                                        @focus="onEditorFocus($event)"
                                        @ready="onEditorReady($event)"
                                    />
                                </div>
                            </div>
                            <!-- end Quill Editor -->

                            <div
                                id="youTubeLink"
                                class="form-group"
                                v-if="classDet.videoLink != ''"
                            >
                                <b-card class="mt-4">
                                    <div class="card-title">
                                        {{
                                            classDet.videoTitle == ""
                                                ? "YouTube Long Title Goes Here"
                                                : classDet.videoTitle
                                        }}
                                    </div>
                                    <div class="actions">
                                        <button
                                            class="btn btn-light"
                                            @click="deleteVideoLink"
                                        >
                                            <i class="icon trash"></i>
                                        </button>
                                    </div>
                                    <div class="media mt-3">
                                        <img
                                            :src="
                                                classDet.videoThumb == ''
                                                    ? 'https://dummyimage.com/160x90/9c9c9c/fff'
                                                    : classDet.videoThumb
                                            "
                                            alt=""
                                            class="mr-3"
                                        />
                                        <div class="media-body">
                                            <small>
                                                {{
                                                    classDet.videoDesc == ""
                                                        ? "Cras sit amet nibh libero, in gravida nulla."
                                                        : classDet.videoDesc
                                                }}
                                            </small>
                                        </div>
                                    </div>
                                    <b-card-text class="pt-4">
                                        <videolink
                                            :vlink="classDet.videoLink"
                                        />
                                    </b-card-text>
                                </b-card>
                            </div>
                        </div>

                        <div
                            class="upload-list"
                            v-show="fileCount > 0 || docCount > 0"
                        >
                            <ul>
                                <li
                                    v-for="pic in classDet.allImages"
                                    :key="pic.name"
                                    class="images"
                                >
                                    <div class="img-wrapper">
                                        <img
                                            :src="pic.imageURL"
                                            width="100"
                                            class="img-fluid"
                                        />
                                    </div>

                                    <b>{{ pic.name + "(" + pic.size + ")" }}</b>

                                    <button
                                        v-if="pic.uploaded == 0"
                                        @click="removeItem(pic.name)"
                                        class="btn btn-light"
                                    >
                                        <i class="icon trash"></i>
                                    </button>

                                    <button
                                        v-else
                                        @click="deleteFile(pic.name)"
                                        class="btn btn-light"
                                    >
                                        <i class="icon trash"></i>
                                    </button>
                                </li>

                                <li
                                    v-for="doc in classDet.allDocs"
                                    :key="doc.name"
                                    v-if="doc.extension == 'pdf'"
                                    class="pdf"
                                >
                                    <div class="img-wrapper">
                                        <i class="icon pdf pdf-md"></i>
                                    </div>

                                    <b>{{ doc.name + "(" + doc.size + ")" }}</b>

                                    <button
                                        @click="deleteFile(doc.name)"
                                        class="btn btn-light"
                                    >
                                        <i class="icon trash"></i>
                                    </button>
                                </li>

                                <li
                                    v-for="doc in classDet.allDocs"
                                    :key="doc.name"
                                    v-if="doc.extension == 'doc' || doc.extension == 'docx'"
                                    class="doc"
                                >
                                    <div class="img-wrapper">
                                        <i class="icon doc doc-md"></i>
                                    </div>

                                    <b>{{
                                        doc.name.substring(0, 35) +
                                            "." +
                                            doc.extension +
                                            "(" +
                                            doc.size +
                                            ")"
                                    }}</b>

                                    <button
                                        @click="deleteFile(doc.name)"
                                        class="btn btn-light"
                                    >
                                        <i class="icon trash"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- RightSubjectPanel -->
                <rsubjectpanel
                    :classObj="classDet"
                    :classDraft="classDraft"
                    :buttonText="buttonText"
                    @classUpdated="updateClassDet"
                />
            </div>

            <b-modal id="AddYouTube" title="Add YouTube link" @ok="onAddvideo">
                <form>
                    <div class="form-group">
                        <input
                            type="text"
                            class="form-control"
                            id="ClassYoutubelink"
                            placeholder="Paste YouTube link here"
                            v-model="classDet.videoLink"
                        />
                        <!-- <b-button variant="primary mt-2" @click="onAddvideo">Add video</b-button> -->
                    </div>
                </form>
            </b-modal>

            <b-modal
                id="AddDocument"
                title="Add Document"
                size="lg"
                @ok="sendDatatoParent"
            >
                <uppydoc
                    :maxFileSizeInBytes="maxFileSize"
                    :classId="classDet.id"
                />
            </b-modal>

            <b-modal
                id="AddImages"
                title="Add Images"
                size="lg"
                @ok="sendDatatoParent"
            >
            <div class="image-uploader">
                <div id="container" class="flexContainer">
                    <div class="row">
                        <div v-for="img in images" :key="img.name"  :id=img.name class="col-md-3">
                            <img height="80px" :src=img.imageURL alt="uploaded image">
                            <button @click="removeItem(img.name)">X</button>
                        </div>
                    </div>
                </div>

                <div class="mb-3"></div>

                <input type="file" multiple @input="handleUpload($event)">
            </div>
                <!-- <uppygen
                    :maxFileSizeInBytes="maxFileSize"
                    :classId="classDet.id"
                /> -->
            </b-modal>
        </div>
    </section>
</template>

<script>
import videolink from "../components/videolink";
// import rawfileupload from '~/components/rawfileupload';
//import filepond from '~/components/filepond';

import uppygen from "../components/uppygen";
import uppydoc from "../components/uppydoc";
import rsubjectpanel from "../components/rightsubjectpanel";

// import * as http from "http";
export default {
    components: {
        videolink,
        uppygen,
        uppydoc,
        rsubjectpanel
    },

    data() {
        return {
            buttonText: "Schedule",
            images: [],
            pdfs: [],
            docs: [],

            classDet: {
                id: 0,
                title: "",
                instruction: "",
                startDate: "",
                submissionDate: "",
                status: "New",
                event: "",
                teacher_id: 0,
                subject_id: 0,
                gradeLevel_id: 0,
                content: "",
                videoLink: "",
                videoTitle: "",
                videoDesc: "",
                videoThumb: "",
                videoPreview: false,
                allImages: [],
                allDocs: [],
                doc: ""
            },

            classDraft: {},

            editorOption: {
                modules: {
                    toolbar: [
                        ["bold", "italic", "underline"],
                        [{ header: 1 }],
                        [{ list: "ordered" }, { list: "bullet" }],
                        [{ indent: "-1" }, { indent: "+1" }],
                        [{ direction: "rtl" }],
                        [{ header: [1, 2, 3, 4, 5, 6, false] }],
                        [{ font: [] }],
                        [{ align: [] }],
                        ["link"]
                    ]
                }
            },

            user: {},
            showImages: false,
            eventName: "test",
            allImages: [],
            doc: [],
            docCount: 0,
            fileCount: 0,
            videoCount: 0,
            previewImage: "",
            classText: "",
            selected: null,
            options: [{ value: null, text: "Please select a subject" }],
            id_teachers: "1",
            draft: "Draft",
            publish: "Live",
            zoom_code: "123",
            is_btn: false,
            classID: 0,
            uploadFiles: false,
            maxFileSize: 1000000000,
            openTextBox: false
        };
    },

    mounted() {
        this.onInit();
        this.flashMessage.setStrategy("multiple");
    },

    computed: {
        isDisabled: function() {
            //This is for disable publish button
            return (
                this.classname == "" ||
                this.instruction == "" ||
                this.selected == null ||
                this.startDate == "" ||
                this.endDate == ""
            );
        },

        draftAvailable: function() {
            return Object.keys(this.classDraft).length > 0;
        }
    },

    methods: {
        onInit() {
            if (this.$route.query.class_id) {
                let class_id = this.$route.query.class_id;
                this.getClassById(class_id);
            } else {
                this.getDraft();
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

        getDraft() {
            //check if there is a class draft made by the currently loggedin teacher
            // that needs to be opened

            axios.get("/api/getDrafts").then(response => {
                console.log("draft-class", response.data);

                let draft = response.data.draft;
                let allImages = response.data.allMedia;
                let allDocs = response.data.allDocs;

                if (draft != null) {
                    this.classDraft = draft;
                    this.classDraft.allImages = allImages;
                    this.classDraft.allDocs = allDocs;
                }
            });
        },

        loadDraft() {
            this.classDet.id = this.classDraft.id;
            this.classDet.title = this.classDraft.title;
            this.classDet.instruction = this.classDraft.instruction;
            this.classDet.subject_id = this.classDraft.subject_id;

            if (this.classDraft.startDate == null) {
                this.classDet.startDate = "";   
            }

            if (this.classDraft.submissionDate == null) {
                this.classDet.submissionDate = "";   
            }

            if (this.classDraft.content != null) {
                this.classDet.content = this.classDraft.content;
                this.openTextBox = 1;
            }

            if (this.classDraft.allImages.length > 0) {
                this.classDet.allImages = this.classDraft.allImages;

                this.showImages = true;
                this.fileCount = this.classDet.allImages.length;
            }

            if (this.classDraft.allDocs.length > 0) {
                this.classDet.allDocs = this.classDraft.allDocs;
                this.docCount = this.classDet.allDocs.length;
            }

            if (this.classDraft.videoLink != null) {
                this.classDet.videoLink = this.classDraft.videoLink;

                //This method is to preview youtube
                var video_id = this.classDet.videoLink.split("/embed/")[1];
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
            }

            this.classDraft = {};
        },

        updateClassDet(upd) {
            //this method updates the composition what is that
            this.classDet = upd;
            console.log("updated event", upd);
        },

        deleteTextBox() {
            this.classDet.content = "";
            this.openTextBox = !this.openTextBox;
        },

        deleteVideoLink() {
            this.classDet.videoLink = "";
            this.classDet.videoPrev = false;
            this.classDet.videoPreview = false;
            this.videoCount = 0;

            this.flashMessage.show({
                status: "success",
                icon: "/images/icon-success.svg",
                blockClass: "flash_message",
                title: "Success",
                message:
                    "Youtube Video Link was removed successfully, Please ensure to save to keep it removed!"
            });
        },

        deleteFile(id) {
            console.log("file id", id);
            let x = {
                class_id: this.classDet.id,
                fileName: id
            };
            axios
                .post("/api/delFiles", x)
                .then(res => {
                    this.refreshImageThumbs();

                    this.flashMessage.show({
                        status: "success",
                        icon: "/images/icon-success.svg",
                        blockClass: "flash_message",
                        title: "Success",
                        message: res.data.message
                    });
                })
                .catch(err => {
                    console.log("delfile-err", err);
                    this.flashMessage.show({
                        status: "error",
                        icon: "/images/icon-error.svg",
                        blockClass: "flash_message",
                        title: "Error",
                        message: err.data.nessage
                    });
                });
        },

        refreshImageThumbs() {
            //this method is called to pull the new images/docs from the server to refresh the display
            axios
                .post("/api/getFiles", this.classDet)
                .then(data => {
                    this.classDet.allImages = data.data.allMedia;
                    this.classDet.allDocs = data.data.allDocs;

                    this.fileCount = data.data.allMedia.length;
                    this.docCount = data.data.allDocs.length;

                    console.log("refresh-images", data);
                })
                .catch(err => {
                    console.log("err-get-thumbs", err);
                });
        },

        onAddvideo() {
            var slink = this.classDet.videoLink;
            console.log("$link", slink);

            if (slink == undefined) {
                this.flashMessage.show({
                    status: "warning",
                    icon: "/images/icon-warning.svg",
                    blockClass: "flash_message",
                    title: "Warning",
                    message:
                        "No Youtube Video Link was entered - please Enter a valid YouTube Url!"
                });

                return false;
            }
            if (slink.includes("embed")) {
                this.flashMessage.show({
                    status: "warning",
                    icon: "/images/icon-warning.svg",
                    blockClass: "flash_message",
                    title: "Warning",
                    message:
                        "Video has been previously added, please change link or delete previous video"
                });

                return false;
            }

            //This method is to preview youtube
            var video_id = this.classDet.videoLink.split("v=")[1];
            var ampersandPosition = video_id.indexOf("&");
            console.log("video id", video_id, ampersandPosition);

            if (ampersandPosition != -1) {
                video_id = video_id.substring(0, ampersandPosition);
            }

            this.classDet.videoID = video_id;
            this.classDet.videoLink =
                "https://www.youtube.com/embed/" + video_id;

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
        },

        viewLargeImage() {
            //this module allows for expanding the image that was uploded into the viewport
        },

        async handleUpload(e) {
          let images = [];
          let pdfs = [];
          let docs = [];

          //check file type and sort into pdfs or images based on their file extension
          var files = e.target.files
          
          for (let i = 0; i < files.length; i++) {
            if (files[i].type === 'application/pdf') {
              this.pdfs.push(files[i]);
              pdfs.push(files[i]);
            } else if (files[i].type == 'application/msword' ||
              files[i].type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
              this.docs.push(files[i]);
              docs.push(files[i]);
            } else if (files[i].type === 'image/jpeg' ||
              files[i].type === 'image/png' ||
              files[i].type === 'image/gif' ||
              files[i].type === 'image/jpg') {

              //create the thumbnail img and add it to the image object
              //console.log(files[i].name)
              const image = await this.buildUrl(files[i]);
              //this.images.push(image);
            }
          }
          //console.log('pdfs',this.pdfs)
          //console.log('images',this.images)
        },

        //creates a data url which is then used as the image src
        async buildUrl(file) {
          return new Promise((resolve, reject) => {
            var fileSelectHandler = (file) => {
              var reader = new window.FileReader();
              reader.onload = (evt) => {

                let image = {
                  file: file,
                  name: file.name,
                  size: file.size,
                  imageURL: evt.target.result,
                  uploaded: 0
                }

                this.images.push(image);
                resolve({
                  ...image
                });
              }
              reader.readAsDataURL(file);
            }
            fileSelectHandler(file)
          })
        },

        //remove a selected item from the uploaded files array
        removeItem(val) {
          this.images = this.images.filter(obj => val !== obj.name);
         // this.sendDatatoParent()
        },

        sendDatatoParent() {
            this.classDet.allImages.push(...this.images);
            // this.appPdfs.push(...pdfs)
            // this.appDocs.push(...docs)

            this.fileCount = this.images.length;
            this.docCount = this.docs.length;
        },

        onAddImage() {
            //This function is to upload image or doc for test purpose
            // let formData = new FormData();
            // for( var i = 0; i < this.doc.length; i++ ){
            //    let file = this.doc[i];
            //    console.log(file);
            //    formData.append('files[' + i + ']', file);
            // }
            // formData.append('files',this.classDet)
            // console.log(formData.values());
            // this.$axios.$post( '/addimage',
            //    formData,
            //    {
            //       headers: {
            //          'Content-Type': 'multipart/form-data'
            //       }
            //    }
            // ).then(function(){
            //    console.log('SUCCESS!!');
            // })
            // .catch(function(){
            //    console.log('FAILURE!!');
            // });
            if (this.classDet.status != "Draft") {
                //save this first
                this.onDraft();
            }
            // console.log(formData.values());
            axios
                .post("/api/uploadClassFile", this.classDet, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(function() {
                    console.log("SUCCESS!!");
                })
                .catch(function() {
                    console.log("FAILURE!!");
                });
        },

        onDraft() {
            //This api is to save draft class - check first if a subject is defined
            if (this.classDet.subject_id > 0) {
                this.classDet.status = "Draft";
                this.classDet.allImages = this.allImages;
                axios
                    .post("/api/updateClassDet", this.classDet)
                    .then(res => {
                        console.log("save-draft", res);

                        this.flashMessage.show({
                            status: "success",
                            icon: "/images/icon-warning.svg",
                            blockClass: "flash_message",
                            title: "Success",
                            message: "Your Class was saved Successfully"
                        });
                        this.classDet = res.data.classes;
                    })
                    .catch(err => {
                        this.flashMessage.show({
                            status: "error",
                            icon: "/images/icon-error.svg",
                            blockClass: "flash_message",
                            title: "Error",
                            message: "An Error Occured whilst saving this Class"
                        });

                        console.log("save-draft-err", err);
                    });
                return true;
            } else {
                this.flashMessage.show({
                    status: "error",
                    icon: "/images/icon-error.svg",
                    blockClass: "flash_message",
                    title: "Error",
                    message:
                        "Plese Select a subject! - this class was not saved"
                });
                return false;
            }
        },

        onSchedule() {
            //this method is used to save the details above
            if (this.classDet.subject_id > 0) {
                this.classDet.status = "Scheduled";
                axios
                    .post("/api/updateClassDet", this.classDet)
                    .then(res => {
                        console.log("save-sched", res);
                        this.flashMessage.show({
                            status: "success",
                            icon: "/images/icon-success.svg",
                            blockClass: "flash_message",
                            title: "Success",
                            message: "Your Class was saved as Scheduled"
                        });
                        this.classDet = res.data.classes;
                        this.$router.push("liveStreamSchedule");
                    })
                    .catch(err => {
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
                        "This class WAS NOT SAVED!. Please select a SUBJECT."
                });
            }
        },

        onPublish() {
            //This api is to save live class

            let formData = new FormData();

            for (var i = 0; i < this.allImages.length; i++) {
                let file = this.allImages[i];

                formData.append("files[" + i + "]", file);
            }
            formData.append("class_doc", this.doc);
            formData.append("id_subjects", this.selected);
            formData.append("id_teachers", this.id_teachers);
            formData.append("class_title", this.classname);
            formData.append("class_instruction", this.instruction);
            formData.append("class_text", this.classText);
            formData.append("class_youtubeLink", this.youtubeLink);
            formData.append("class_youtubeDesc", this.youtubeDesc);
            formData.append("class_youtubeThum", this.youtubeThum);
            formData.append("class_status", this.publish);
            formData.append("class_startdate", this.startDate);
            formData.append("class_submissiondate", this.endDate);
            axios
                .post("/createclass", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(response => {
                    console.log(response);
                    alert("Your submission is sucessful");
                })
                .catch(error => console.log(error));
            console.log("publish test");
        },

        handleFilesUpload() {
            //This function is to get all image data , must be saved as draft first
            if (this.onDraft()) {
                let formData = new FormData();
                formData.append("file", this.allImages);
                formData.append("id", this.classDet.id);

                axios
                    .post("/api/uploadFiles", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    })
                    .then(res => {
                        console.log("file upload", res);
                        axios
                            .post("/api/getFiles", this.classDet)
                            .then(data => {
                                this.classDet.allImages = data.data.allMedia;
                                this.fileCount = data.data.allMedia.length;
                            });
                    })
                    .catch(err => {
                        console.log("file-upload-err", err);
                    });
            } else {
                this.flashMessage.show({
                    status: "error",
                    icon: "/images/icon-error.svg",
                    blockClass: "flash_message",
                    title: "Error",
                    message:
                        "Upload was not completed - Please SAVE CLASS before Attaching Files"
                });
            }
        },

        handleDocUpload() {
            //This function is to get doc data
            // this.classDet.doc = this.$refs.file.files[0];
            
            if (this.onDraft()) {
                let formData = new FormData();
                formData.append("file", this.doc);
                formData.append("id", this.classDet.id);

                axios
                    .post("/api/uploadDocs", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    })
                    .then(res => {
                        console.log("doc-upload", res);
                        axios
                            .post("/api/getFiles", this.classDet)
                            .then(data => {
                                this.classDet.allDocs = data.data.allDocs;
                                this.docCount = data.data.allDocs.length;
                            });
                    })
                    .catch(err => {
                        console.log("doc-upload-err", err);
                    });
            } else {
                this.flashMessage.show({
                    status: "error",
                    icon: "/images/icon-error.svg",
                    blockClass: "flash_message",
                    title: "Error",
                    message:
                        "Document Upload was not completed - Please Save CLASS before attaching files"
                });
            }
        },

        onEditorBlur(editor) {
            console.log("editor blur!", editor);
        },
        onEditorFocus(editor) {
            console.log("editor focus!", editor);
        },
        onEditorReady(editor) {
            console.log("editor ready!", editor);
        }
    }
};
</script>

<style scoped>
.btn_upload {
    padding: 17px 30px 12px;
    color: #fff;
    text-align: center;
    position: relative;
    display: inline-block;
    overflow: hidden;
    z-index: 3;
    white-space: nowrap;
}

.btn_upload input {
    position: absolute;
    width: 100%;
    left: 0;
    top: 0;
    width: 100%;
    height: 105%;
    cursor: pointer;
    opacity: 0;
}

.upload-list li {
    display: flex;
    flex-direction: row;
    width: 100%;
    margin-bottom: 0.5rem;
    list-style: none;
    border: solid 1px #ced4da;
    border-radius: 0.25rem;
    justify-content: space-between;
    align-items: center;
}

.upload-list li.images {
    background: #ecfaf4;
    color: #00af80;
}

.upload-list li.pdf {
    background: #ffe7e7;
    color: #fb5252;
}

.upload-list li.doc {
    background: #e6effe;
    color: #1273eb;
}

.image-uploader img, .image-uploader button {
    width: 100%;
}
</style>
