<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <!--Widget Row 1-->
                    <div class="campus-info widget-row">
                        <div class="row">
                            <div class="col-sm-6 col-md-4 widget mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="badge badge-primary">{{ adminDet.teachersCount }}</h3>
                                        <small>Teachers</small>
                                        <br />
                                        <b-button
                                            v-b-modal.addteacher
                                            variant="primary"
                                            >Add Teacher</b-button
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 widget mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="badge badge-success">{{ adminDet.studentsCount }}</h3>
                                        <small>Students</small>
                                        <br />
                                        <b-button
                                            v-b-modal.addstudent
                                            variant="success mr-1"
                                            >Add Student</b-button
                                        >
                                        <b-button
                                            v-b-modal.addstudentlist
                                            variant="success"
                                            >Upload List</b-button
                                        >
                                    </div>
                                </div>
                            </div>

                            <div v-if="isFeePayingSchool" class="col-sm-6 col-md-4 widget mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="badge badge-warning">89%</h3>
                                        <small>Fees health</small>
                                        <br />
                                        <button class="btn btn-warning">
                                            Check Fees
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!--add teacher modal-->

                            <div>
                                <b-modal
                                    id="addteacher"
                                    size="md"
                                    title="Add Teacher"
                                    ref="teacher-modal"
                                >
                                    <div
                                        class="form-group d-flex justify-content-center mb-4"
                                    >
                                        <div class="">
                                            <img
                                                class="avatar avatar-xl rounded-circle"
                                                src="/images/blank-avatar.png"
                                                alt=""
                                            />
                                            <div
                                                class="btn-group d-flex flex-row mt-2"
                                                role="group"
                                                aria-label="Avatar Options"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    <i class="icon upload"></i>
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

                                    <div class="form-group row mb-2">
                                        <div class="col-12">
                                            <b-field :message="teacherValidator.name">
                                                <b-input type="text" name="name" placeholder="Name" v-model="teacherForm.name" :disabled="loading"/>
                                            </b-field>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-2">
                                        <div class="col-12">
                                            <b-field :message="teacherValidator.class_id">
                                                <b-form-select
                                                    v-model="teacherForm.class_id"
                                                    :options="classes"
                                                    class="mb-3"
                                                ></b-form-select>
                                            </b-field>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <b-field :message="teacherValidator.email">
                                                <b-input type="email" name="email" placeholder="E-mail" v-model="teacherForm.email" :disabled="loading"/>
                                            </b-field>
                                        </div>
                                    </div>

                                    <template #modal-footer>
                                        <b-button
                                            variant="secondary"
                                            @click="show = false"
                                        >
                                            Close
                                        </b-button>

                                        <b-button
                                            variant="primary"
                                            @click="addTeacher"
                                            :disabled="preventTeacherSubmit"
                                            :class="{ 'is-loading': loading }"
                                        >
                                            {{ loading ? '' : 'OK' }} <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                                        </b-button>
                                    </template>
                                </b-modal>
                            </div>
                            <!--end modal-->
                            
                            <!--add student modal-->
                            <div>
                                <b-modal
                                    id="addstudent"
                                    size="md"
                                    title="Add Student"
                                    ref="student-modal"
                                >
                                    <div class="form-group row mb-2">
                                        <div class="col-12">
                                            <b-field :message="studentValidator.firstName">
                                                <b-input type="text" placeholder="First Name" v-model="studentForm.firstName" :disabled="loading"/>
                                            </b-field>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-2">
                                        <div class="col-12">
                                            <b-field :message="studentValidator.middleName">
                                                <b-input type="text" placeholder="Middle Name (optional)" v-model="studentForm.middleName" :disabled="loading"/>
                                            </b-field>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-2">
                                        <div class="col-12">
                                            <b-field :message="studentValidator.lastName">
                                                <b-input type="text" placeholder="Last Name" v-model="studentForm.lastName" :disabled="loading"/>
                                            </b-field>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-2">
                                        <div class="col-12">
                                            <b-field :message="studentValidator.email">
                                                <b-input type="email" name="E-mail" placeholder="E-mail" v-model="studentForm.email" :disabled="loading"/>
                                            </b-field>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-2">
                                        <div class="col-12">
                                            <b-field :message="studentValidator.gender">
                                                <b-form-select
                                                    v-model="studentForm.gender"
                                                    :options="gender"
                                                    class="mb-3"
                                                ></b-form-select>
                                            </b-field>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-2">
                                        <div class="col-12">
                                            <b-field :message="studentValidator.dateOfBirth">
                                                <b-form-datepicker
                                                    placeholder="Date Of Birth (optional)"
                                                    id="dateOfBirth"
                                                    v-model="studentForm.dateOfBirth"
                                                    :disabled="loading"
                                                    class="mb-2"
                                                ></b-form-datepicker>
                                            </b-field>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-2">
                                        <div class="col-12">
                                            <b-field :message="studentValidator.class_id">
                                                <b-form-select
                                                    v-model="studentForm.class_id"
                                                    :options="classes"
                                                    :disabled="loading"
                                                    class="mb-3"
                                                ></b-form-select>
                                            </b-field>
                                        </div>
                                    </div>

                                    <template #modal-footer>
                                        <b-button
                                            variant="secondary"
                                            @click="show = false"
                                        >
                                            Close
                                        </b-button>

                                        <b-button
                                            variant="primary"
                                            @click="addStudent"
                                            :disabled="preventStudentSubmit"
                                            :class="{ 'is-loading': loading }"
                                        >
                                            {{ loading ? '' : 'OK' }} <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                                        </b-button>
                                    </template>
                                </b-modal>
                            </div>
                            <!--end add student modal-->
                            
                            <!--upload Student list-->
                            <div>
                                <b-modal
                                    id="addstudentlist"
                                    size="md"
                                    title="Upload Student List"
                                >
                                    <div class="form-group row mb-2">
                                        <div class="col-sm-8">
                                            <select
                                                class="form-control"
                                                id="class"
                                            >
                                                <option>Daycare</option>
                                                <option
                                                    >Lower Reception (3-4
                                                    yrs)</option
                                                >
                                                <option
                                                    >Upper Reception (4-5
                                                    yrs)</option
                                                >
                                                <option>Class 1</option>
                                                <option>Class 2</option>
                                                <option>Class 3</option>
                                                <option>Class 4</option>
                                                <option>Class 6</option>
                                                <option>Class 6</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input-group mb-2">
                                        <div class="custom-file">
                                            <input
                                                type="file"
                                                class="custom-file-input"
                                                id="inputGroupFile01"
                                            />
                                            <label
                                                class="custom-file-label"
                                                for="inputGroupFile01"
                                                >Upload CSV file</label
                                            >
                                        </div>
                                    </div>
                                    <p><a href="#">Need help?</a></p>
                                </b-modal>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            adminDet: [],
            classes: [{ value: null, text: "Please select a class (optional)" }],
            gender: [
                { value: null, text: "Please select a gender" },
                { value: 'boy', text: "Boy" },
                { value: 'girl', text: "Girl" }
            ],

            teacherValidator: {
                name: "",
                class_id: "",
                email: ""
            },

            studentValidator: {
                firstName: "",
                middleName: "",
                lastName: "",
                email: "",
                class_id: "",
                gender: "",
                dateOfBirth: ""
            },

            error: "",
            loading: false,

            teacherForm: {
                name: "",
                class_id: null,
                email: ""
            },

            studentForm: {
                firstName: "",
                middleName: "",
                lastName: "",
                email: "",
                class_id: null,
                gender: null,
                dateOfBirth: ""
            }
        };
    },

    computed: {
        preventTeacherSubmit() {
            return this.teacherForm.name == "" ||
                this.teacherForm.email  == ""
                ? true
                : false;
        },

         preventStudentSubmit() {
            return this.studentForm.firstName == "" ||
                this.studentForm.lastName == "" ||
                this.studentForm.email == "" ||
                this.studentForm.gender == null
                ? true
                : false;
        },

        isFeePayingSchool() {
            if (this.adminDet.settings) {
                return this.adminDet.settings.is_fee_paying_school == 1 ? true : false;
            }
        }
    },

    mounted() {
        this.onInit();
    },

    methods: {
        async onInit() {
             // Get classes
            await this.getClasses();

            // Get Admin Details
            axios.get("/api/admin/getAdminDet")
            .then(response => {
                this.adminDet = response.data.adminDet;
            });
        },

        async getClasses() {
            axios.get("/api/getClasses").then(response => {
                response.data.classes.forEach(element => {
                    let x = {
                        value: element.id,
                        text: element.title
                    };

                    this.classes.push(x);
                });
            });
        },

        async addTeacher() {
            this.loading = true;

            const { name, class_id, email } = this.teacherForm;
            const { data } = await axios.post(API.addTeacher, {
                name,
                class_id,
                email
            });

            if ("error" in data) {
                this.loading = false;
                this.error = data.error;
                
                this.$bvToast.toast(data.error, {
                    title: `Something went wrong!`,
                    autoHideDelay: 5000,
                    variant: 'success',
                    appendToast: false
                })
            } else if ("errors" in data) {
                this.validator = {
                    ...this.validator,
                    ...data.errors
                };
            } else {
                this.loading = false;
                this.hideModal('teacher-modal');

                this.$buefy.snackbar.open({
                    message: "Successfully added new teacher",
                    type: "is-success",
                    position: "is-top",
                    actionText: "close"
                });

                this.$bvToast.toast(`${this.teacherForm.name} will receive an invite to create an account and join your school`, {
                    title: `Invite Sent To ${this.teacherForm.name}`,
                    autoHideDelay: 5000,
                    variant: 'success',
                    appendToast: false
                });
            }
        },

        async addStudent() {
            this.loading = true;

            const { firstName, middleName, lastName, email, class_id, gender, dateOfBirth } = this.studentForm;
            const { data } = await axios.post(API.addStudent, {
                firstName,
                middleName,
                lastName,
                email,
                class_id,
                gender,
                dateOfBirth
            });

            if ("error" in data) {
                this.loading = false;
                this.error = data.error;
            } else if ("errors" in data) {
                this.validator = {
                    ...this.validator,
                    ...data.errors
                };
            } else {
                this.loading = false;
                this.hideModal('student-modal');

                this.$buefy.snackbar.open({
                    message: "Successfully added new student",
                    type: "is-success",
                    position: "is-top",
                    actionText: "close"
                });

                this.$bvToast.toast(`The new student will receive an invite to create an account and join your school`, {
                    title: `Invite Sent To ${this.studentForm.firstName} ${this.studentForm.lastName}`,
                    autoHideDelay: 5000,
                    variant: 'success',
                    appendToast: false
                })
            }
        },

        showModal(modal) {
            this.$refs[modal].show()
        },

        hideModal(modal) {
            this.$refs[modal].hide()
        },
    }
};
</script>

<style></style>
