<template>
    <section class="content">
        <div class="content__inner">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <select
                                class="custom-select mb-3"
                                v-model="class_id"
                                @change="getStudentsByClassId"
                            >
                                <option
                                    v-for="item in classes"
                                    :key="item.value"
                                    :value="item.value"
                                    :selected="item.value == null"
                                    >{{ item.text }}</option
                                >
                            </select>
                            <button
                                type="button"
                                class="btn btn-success btn-block"
                            >
                                Add Pupil to this class
                            </button>
                            <!--setudent list-->
                            <div class="studentlist list-group mt-4">
                                <button
                                    v-for="stud in studentDet"
                                    :key="stud.id"
                                    @click="changeStudent(stud.id)"
                                    type="button"
                                    class="list-group-item list-group-item-action d-flex justify-content-between"
                                    :class="{ active: stud.id == student.id }"
                                >
                                    {{ stud.full_name }}
                                </button>
                            </div>
                            <!--end teachers list-->
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                    <student-info :student="student"></student-info>
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
            studentDet: [],
            student: [],

            classes: [],
            class_id: null,
            gender: [
                { value: null, text: "Please select a gender" },
                { value: "boy", text: "Boy" },
                { value: "girl", text: "Girl" }
            ],

            error: "",
            loading: false
        };
    },

    mounted() {
        this.onInit();
    },

    methods: {
        async onInit() {
            // Get classes
            await this.getClasses();

            // Get Students
            axios.get("/api/admin/getStudentDet").then(response => {
                this.studentDet = response.data.studentDet;

                if (response.data.studentDet.length > 0) {
                    this.student = this.studentDet[0];
                }
            });
        },

        async getClasses() {
            axios.get("/api/getClasses").then(response => {
                this.classes = [{ value: null, text: "Show All" }];

                response.data.classes.forEach(element => {
                    let x = {
                        value: element.id,
                        text: element.title
                    };

                    this.classes.push(x);
                });
            });
        },

        getStudentsByClassId() {
            if (this.class_id == null) {
                this.onInit();
                return;
            }

            axios
                .get(`/api/admin/getStudentsByClassId/${this.class_id}`)
                .then(response => {
                    this.studentDet = response.data.studentDet;

                    if (response.data.studentDet.length > 0) {
                        this.student = this.studentDet[0];
                    }
                });
        },

        changeStudent(student_id) {
            if (this.student.id == student_id) {
                // Student already set
                return;
            }

            let self = this;

            return this.studentDet.filter(item => {
                if (item.id == student_id) {
                    return (self.student = item);
                }
            });
        }
    }
};
</script>

<style></style>
