<template>
    <section class="content">
        <div class="content__inner">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <button
                                type="button"
                                class="btn btn-success btn-block"
                            >
                                Add Teacher
                            </button>
                            <!--teachers list-->
                            <div class="list-group mt-4">
                                <button
                                    v-for="teach in teacherDet"
                                    :key="teach.id"
                                    @click="changeTeacher(teach.id)"
                                    type="button"
                                    class="list-group-item list-group-item-action d-flex justify-content-between"
                                    :class="{ active: teach.id == teacher.id }"
                                >
                                    {{ teach.name }}
                                    <span
                                        v-if="teach.classes.length > 0"
                                        class="badge lower-reception"
                                        >{{ teach.classes.title }}</span
                                    >
                                </button>
                            </div>
                            <!--end teachers list-->
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-8 col-lg-8 ">
                    <div class="card">
                        <div class="card-body">
                            <!--school settings-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h6>Display</h6>
                                    </div>

                                    <div
                                        class="form-group d-flex justify-content-center mt-4"
                                    >
                                        <div class="">
                                            <img
                                                class="avatar avatar-xl avatar-preview rounded-circle"
                                                :src="avatar_image"
                                                :alt="teacher.name"
                                                @click="pickAvatar"
                                            />
                                            <input
                                                type="file"
                                                @change="previewImage"
                                                ref="avatar"
                                                accept="image/*"
                                                style="display: none;"
                                            />

                                            <div
                                                class="btn-group d-flex flex-row mt-2"
                                                role="group"
                                                aria-label="Avatar Options"
                                            >
                                                <button
                                                    @click="uploadAvatar"
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    <i
                                                        v-show="!uploading"
                                                        class="icon upload"
                                                    ></i>
                                                    <i
                                                        v-show="uploading"
                                                        class="fa fa-spinner fa-spin"
                                                    ></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-danger"
                                                >
                                                    <i
                                                        class="icon trash-white"
                                                    ></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="nickname"
                                            class="col-sm-3 col-form-label text-right"
                                            >Display as</label
                                        >
                                        <div class="col-sm-6">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="nickname"
                                                placeholder="Miss Mary"
                                                v-model="teacher.name"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end school settings-->

                            <!--school settings-->
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h6>School</h6>
                                    </div>
                                    <div class="actions">
                                        <button class="btn btn-primary">
                                            <i class="icon save"></i>
                                        </button>
                                    </div>

                                    <div class="form-group row">
                                        <label
                                            for="class"
                                            class="col-sm-3 col-form-label text-right"
                                            >Class</label
                                        >
                                        <div class="col-sm-4">
                                            <select
                                                v-model="class_id"
                                                class="form-control"
                                                id="class"
                                            >
                                                <option>Select Class</option>
                                                <option
                                                    v-for="item in classes"
                                                    :key="item.id"
                                                    :value="item.id"
                                                    :selected="
                                                        teacher.id ==
                                                            item.teacher_id
                                                    "
                                                    >{{ item.title }}</option
                                                >
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end school settings-->

                            <!--privledges-->
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h6>Privledges</h6>
                                    </div>
                                    <div class="actions">
                                        <button class="btn btn-primary">
                                            <i class="icon save"></i>
                                        </button>
                                    </div>

                                    <div
                                        class="custom-control custom-radio mt-3"
                                    >
                                        <input
                                            type="radio"
                                            id="allow"
                                            name="privledges"
                                            class="custom-control-input"
                                            checked
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="allow"
                                            >Allow</label
                                        >
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input
                                            type="radio"
                                            id="suspend"
                                            name="privledges"
                                            class="custom-control-input"
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="suspend"
                                            >Suspend</label
                                        >
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input
                                            type="radio"
                                            id="delete"
                                            name="privledges"
                                            class="custom-control-input"
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="delete"
                                            >Delete</label
                                        >
                                    </div>
                                </div>
                            </div>
                            <!--end privledges-->

                            <!--Personal details-->
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h6>Personal</h6>
                                    </div>
                                    <div class="actions">
                                        <button class="btn btn-primary">
                                            <i class="icon save"></i>
                                        </button>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <label
                                            for="firstname"
                                            class="col-sm-3 col-form-label text-right"
                                            >First name</label
                                        >
                                        <div class="col-sm-6">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="firstname"
                                                placeholder="First name"
                                                v-model="teacher.firstName"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="lastname"
                                            class="col-sm-3 col-form-label text-right"
                                            >Last name</label
                                        >
                                        <div class="col-sm-6">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="lastname"
                                                placeholder="Last name"
                                                v-model="teacher.lastName"
                                            />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label
                                            for="lastname"
                                            class="col-sm-3 col-form-label text-right"
                                            >Gender</label
                                        >
                                        <div class="col-sm-3">
                                            <select
                                                class="form-control"
                                                id="gender"
                                                v-model="teacher.gender"
                                            >
                                                <option
                                                    :selected="
                                                        teacher.gender == 'male'
                                                    "
                                                    value="male"
                                                    >Male</option
                                                >
                                                <option
                                                    :selected="
                                                        teacher.gender ==
                                                            'female'
                                                    "
                                                    value="female"
                                                    >Female</option
                                                >
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label
                                            for="lastname"
                                            class="col-sm-3 col-form-label text-right"
                                            >ID Number</label
                                        >
                                        <div class="col-sm-6">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="idnumber"
                                                placeholder="ID number"
                                                v-model="teacher.idNumber"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="hometelephone"
                                            class="col-sm-3 col-form-label text-right"
                                            >Home Number</label
                                        >
                                        <div class="col-sm-6">
                                            <input
                                                type="tel"
                                                class="form-control"
                                                id="hometelephone"
                                                placeholder="Home telephone"
                                                v-model="teacher.homeNumber"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="mobile"
                                            class="col-sm-3 col-form-label text-right"
                                            >Mobile Number</label
                                        >
                                        <div class="col-sm-6">
                                            <input
                                                type="tel"
                                                class="form-control"
                                                id="mobile"
                                                placeholder="Mobile telephone"
                                                v-model="teacher.mobileNumber"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="email"
                                            class="col-sm-3 col-form-label text-right"
                                            >Email</label
                                        >
                                        <div class="col-sm-6">
                                            <input
                                                type="email"
                                                class="form-control"
                                                id="email"
                                                placeholder="Email address"
                                                v-model="teacher.email"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end personal details-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import StudentInfo from "./components/StudentInfo.vue";

export default {
    components: {
        StudentInfo
    },

    data() {
        return {
            classes: [],
            class_id: null,

            teacherDet: [],
            teacher: [],

            attachment: null,
            avatarData: null,

            error: "",
            uploading: false,
            loading: false
        };
    },

    computed: {
        avatar_image() {
            return this.avatarData == null
                ? this.teacher.avatar_url
                : this.avatarData;
        }
    },

    mounted() {
        this.onInit();
    },

    methods: {
        pickAvatar() {
            this.$refs.avatar.click();
        },

        previewImage(event) {
            let input = event.target;

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    this.avatarData = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
                this.attachment = input.files[0];
            }
        },

        uploadAvatar() {
            let formData = new FormData();

            if (this.attachment == null) {
                return;
            }

            formData.append("teacher_id", this.teacher.id);
            formData.append("avatar", this.attachment);

            let url = "/api/admin/uploadTeacherAvatar";
            let headers = { "Content-Type": "multipart/form-data" };

            this.uploading = true;

            axios
                .post(url, formData, { headers })
                .then(res => {
                    this.uploading = false;
                    this.attachment = null;

                    this.$buefy.snackbar.open({
                        message: "Successfully uploaded successfully!",
                        type: "is-success",
                        position: "is-top",
                        actionText: "close"
                    });
                })
                .catch(err => {
                    this.uploading = false;

                    if (err.response.data.error.avatar) {
                        this.$buefy.snackbar.open({
                            message: err.response.data.error.avatar,
                            type: "is-error",
                            position: "is-top",
                            actionText: "close"
                        });
                    }
                });
        },

        async onInit() {
            // Get classes
            await this.getClasses();

            // Get Teachers
            axios.get("/api/admin/getTeacherDet").then(response => {
                this.teacherDet = response.data.teacherDet;

                if (response.data.teacherDet.length > 0) {
                    this.teacher = this.teacherDet[0];

                    if (this.teacher.classes.length > 0) {
                        this.class_id = this.teacher.classes[0].id;
                    }
                }
            });
        },

        async getClasses() {
            axios.get("/api/getClasses").then(response => {
                this.classes = response.data.classes;
            });
        },

        changeTeacher(teacher_id) {
            if (this.teacher.id == teacher_id) {
                // Teacher already set
                return;
            }

            let self = this;

            return this.teacherDet.filter(item => {
                if (item.id == teacher_id) {
                    return (self.teacher = item);
                }
            });
        }
    }
};
</script>

<style>
.avatar-preview {
    cursor: pointer;
}
</style>
