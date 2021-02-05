<template>
    <div class="card">
        <div class="card-body">
            <div class="actions">
                <button @click="saveStudentDet" class="btn btn-primary">
                    <i v-show="saving" class="fa fa-spinner spin"></i>
                    <i v-show="!saving" class="icon save"></i>
                </button>
            </div>
            <div>
                <b-tabs>
                    <b-tab title="Student Details" active>
                        <!--student details tab-->
                        <div id="studentDetails">
                            <div class="buttongroup-wrapper">
                                <button class="btn btn-secondary">
                                    Issue new Student PIN
                                </button>
                                <button href="#" class="btn btn-warning">
                                    Suspend access
                                </button>
                                <button href="#" class="btn btn-danger">
                                    Delete
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
                                        v-model="student.firstName"
                                    />
                                </div>
                            </div>

                            <div
                                v-if="student.middleName != null"
                                class="form-group row mt-4"
                            >
                                <label
                                    for="middlename"
                                    class="col-sm-3 col-form-label text-right"
                                    >Middle name</label
                                >
                                <div class="col-sm-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="middlename"
                                        placeholder="Middle name"
                                        v-model="student.middleName"
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
                                        v-model="student.lastName"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="gender"
                                    class="col-sm-3 col-form-label text-right"
                                    >Gender</label
                                >
                                <div class="col-sm-3">
                                    <select
                                        class="form-control"
                                        id="gender"
                                        v-model="student.gender"
                                    >
                                        <option
                                            value="boy"
                                            :selected="student.gender == 'boy'"
                                            >Boy</option
                                        >
                                        <option
                                            value="girl"
                                            :selected="student.gender == 'girl'"
                                            >Girl</option
                                        >
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label
                                    for="dob"
                                    class="col-sm-3 col-form-label text-right"
                                    >Date of Birth</label
                                >
                                <div class="col-sm-6">
                                    <input
                                        type="date"
                                        id="dob"
                                        name="dob"
                                        class="form-control"
                                        v-model="student.dateOfBirth"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="campus"
                                    class="col-sm-3 col-form-label text-right"
                                    >Campus</label
                                >
                                <div class="col-sm-4">
                                    <select class="form-control" id="campus">
                                        <option>Bernardin</option>
                                        <option>Buswell</option>
                                        <option>Curepipe</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="class"
                                    class="col-sm-3 col-form-label text-right"
                                    >Class</label
                                >
                                <div class="col-sm-4">
                                    <select class="form-control" id="class">
                                        <option>Daycare</option>
                                        <option>Lower Reception</option>
                                        <option>Upper Reception</option>
                                        <option>Class 1</option>
                                        <option>Class 2</option>
                                        <option>Class 3</option>
                                        <option>Class 4</option>
                                        <option>Class 6</option>
                                        <option>Class 6</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--end student details tab-->
                    </b-tab>

                    <b-tab title="Parents Details">
                        <!--parents tab-->
                        <div id="parents" class="mt-3">
                            <div class="form-group row">
                                <label
                                    for="fatherfirstname"
                                    class="col-sm-3 col-form-label text-right"
                                    >Father's First name</label
                                >
                                <div class="col-sm-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="fatherfirstname"
                                        placeholder="Father's first name"
                                        v-model="student.fatherFirstName"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="mothersfirstname"
                                    class="col-sm-3 col-form-label text-right"
                                    >Mother's First name</label
                                >
                                <div class="col-sm-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="mothersfirstname"
                                        placeholder="Mothers's first name"
                                        v-model="student.motherFirstName"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="familyname"
                                    class="col-sm-3 col-form-label text-right"
                                    >Last name</label
                                >
                                <div class="col-sm-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="familyname"
                                        placeholder="Family name"
                                        v-model="student.familyLastName"
                                    />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group row">
                                <label
                                    for="fathertel"
                                    class="col-sm-3 col-form-label text-right"
                                    >Father's telephone</label
                                >
                                <div class="col-sm-6">
                                    <input
                                        type="tel"
                                        class="form-control"
                                        id="fathertel"
                                        placeholder="Enter number"
                                        v-model="student.fatherPhoneNo"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="fatheremail"
                                    class="col-sm-3 col-form-label text-right"
                                    >Father's email</label
                                >
                                <div class="col-sm-6">
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="fatheremail"
                                        placeholder="Father's email"
                                        v-model="student.fatherEmail"
                                    />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group row">
                                <label
                                    for="mothertel"
                                    class="col-sm-3 col-form-label text-right"
                                    >Mother's telephone</label
                                >
                                <div class="col-sm-6">
                                    <input
                                        type="tel"
                                        class="form-control"
                                        id="mothertel"
                                        placeholder="Enter number"
                                        v-model="student.motherPhoneNo"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="mothersemail"
                                    class="col-sm-3 col-form-label text-right"
                                    >Mothers's email</label
                                >
                                <div class="col-sm-6">
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="mothersemail"
                                        placeholder="Mother's email"
                                        v-model="student.motherEmail"
                                    />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group row">
                                <label
                                    for="hometel"
                                    class="col-sm-3 col-form-label text-right"
                                    >Home telephone</label
                                >
                                <div class="col-sm-6">
                                    <input
                                        type="tel"
                                        class="form-control"
                                        id="hometel"
                                        placeholder="Enter number"
                                        v-model="student.homePhoneNo"
                                    />
                                </div>
                            </div>
                        </div>
                        <!--end parents tab-->
                    </b-tab>

                    <b-tab title="Fees">
                        <!--fees tab-->
                        <div id="fees" class="mt-3">
                            <div class="d-flex justify-content-between">
                                <select class="custom-select w-25">
                                    <option>2020</option>
                                </select>
                                <button class="btn btn-success">
                                    Save all
                                </button>
                            </div>
                            <!--Table-->
                            <table
                                id="tablePreview"
                                class="table table-bordered table-striped mt-4"
                            >
                                <!--Table head-->
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Paid Date</th>
                                        <th class="hide-for-small-only">
                                            Reciept No
                                        </th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <!--Table head-->
                                <!--Table body-->
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                            January
                                        </th>
                                        <td>30 Dec 2019</td>
                                        <td class="hide-for-small-only">
                                            2578
                                        </td>
                                        <td>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic example"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    Save
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            February
                                        </th>
                                        <td>30 Jan 2020</td>
                                        <td class="hide-for-small-only">
                                            3785
                                        </td>
                                        <td>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic example"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    Save
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            March
                                        </th>
                                        <td>
                                            <input
                                                type="date"
                                                class="form-control"
                                            />
                                        </td>
                                        <td class="hide-for-small-only">
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic example"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    Save
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            April
                                        </th>
                                        <td>
                                            <input
                                                type="date"
                                                class="form-control"
                                            />
                                        </td>
                                        <td class="hide-for-small-only">
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic example"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    Save
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">May</th>
                                        <td>
                                            <input
                                                type="date"
                                                class="form-control"
                                            />
                                        </td>
                                        <td class="hide-for-small-only">
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic example"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    Save
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            June
                                        </th>
                                        <td>
                                            <input
                                                type="date"
                                                class="form-control"
                                            />
                                        </td>
                                        <td class="hide-for-small-only">
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic example"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    Save
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            July
                                        </th>
                                        <td>
                                            <input
                                                type="date"
                                                class="form-control"
                                            />
                                        </td>
                                        <td class="hide-for-small-only">
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic example"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    Save
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            August
                                        </th>
                                        <td>
                                            <input
                                                type="date"
                                                class="form-control"
                                            />
                                        </td>
                                        <td class="hide-for-small-only">
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic example"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    Save
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            September
                                        </th>
                                        <td>
                                            <input
                                                type="date"
                                                class="form-control"
                                            />
                                        </td>
                                        <td class="hide-for-small-only">
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic example"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    Save
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            October
                                        </th>
                                        <td>
                                            <input
                                                type="date"
                                                class="form-control"
                                            />
                                        </td>
                                        <td class="hide-for-small-only">
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic example"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    Save
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            November
                                        </th>
                                        <td>
                                            <input
                                                type="date"
                                                class="form-control"
                                            />
                                        </td>
                                        <td class="hide-for-small-only">
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic example"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    Save
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            December
                                        </th>
                                        <td>
                                            <input
                                                type="date"
                                                class="form-control"
                                            />
                                        </td>
                                        <td class="hide-for-small-only">
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic example"
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    Save
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--end fees tab-->
                    </b-tab>
                </b-tabs>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["student"],

    data() {
        return {
            saving: false,

            validator: {
                firstName: "",
                middleName: "",
                lastName: "",
                gender: "",
                dateOfBirth: "",
                fatherFirstName: "",
                motherFirstName: "",
                familyLastName: "",
                fatherPhoneNo: "",
                motherPhoneNo: "",
                fatherEmail: "",
                motherEmail: "",
                homePhoneNo: ""
            }
        };
    },

    methods: {
        async saveStudentDet() {
            this.saving = true;

            const {
                id,
                firstName,
                middleName,
                lastName,
                gender,
                dateOfBirth,
                fatherFirstName,
                motherFirstName,
                familyLastName,
                fatherPhoneNo,
                motherPhoneNo,
                fatherEmail,
                motherEmail,
                homePhoneNo
            } = this.student;
            const { data } = await axios.post(API.saveStudent, {
                id,
                firstName,
                middleName,
                lastName,
                gender,
                dateOfBirth,
                fatherFirstName,
                motherFirstName,
                familyLastName,
                fatherPhoneNo,
                motherPhoneNo,
                fatherEmail,
                motherEmail,
                homePhoneNo
            });

            if ("error" in data) {
                this.saving = false;
                this.error = data.error;
            } else if ("errors" in data) {
                this.validator = {
                    ...this.validator,
                    ...data.errors
                };
            } else {
                this.saving = false;

                this.$buefy.snackbar.open({
                    message: data.success,
                    type: "is-success",
                    position: "is-top",
                    actionText: "close"
                });
            }
        }
    }
};
</script>

<style></style>
