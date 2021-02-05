<template>
    <section class="container pt-100">
        <div class="content__inner">
            <div class="row">
                <section id="create" class="col-md-6 offset-md-3 mb-4">
                    <div class="card" v-if="roleConfirmed">
                        <b-field
                            label="Name"
                            :type="inputState(errors.name)"
                            :message="errors.name"
                        >
                            <b-input
                                v-model="form.name"
                                icon="account"
                                :loading="loading"
                                :disabled="loading"
                            />
                        </b-field>
                        <b-field
                            label="Email"
                            :type="inputState(errors.email)"
                            :message="errors.email"
                        >
                            <b-input
                                v-model="form.email"
                                type="email"
                                icon="email"
                                :loading="loading"
                                :disabled="loading"
                            />
                        </b-field>
                        <b-field
                            label="Password"
                            :type="inputState(errors.password)"
                            :message="errors.password"
                        >
                            <b-input
                                type="password"
                                v-model="form.password"
                                password-reveal
                                :loading="loading"
                                :disabled="loading"
                            />
                        </b-field>
                        <b-field
                            label="Confirm Password"
                            :type="inputState(errors.confirm_password)"
                            :message="errors.confirm_password"
                        >
                            <b-input
                                type="password"
                                v-model="form.confirm_password"
                                password-reveal
                                :loading="loading"
                                :disabled="loading"
                            />
                        </b-field>
                        <div class="pt-4">
                            <b-button
                                type="is-primary"
                                @click="register"
                                :loading="loading"
                                :disabled="loading"
                                rounded
                                >{{ `Register as a ${form.role}` }}</b-button
                            >
                        </div>
                    </div>
                    
                    <div class="card" v-else>
                        <b-field label="Register as" type="is-primary">
                            <b-select
                                placeholder="You're a student or a teacher"
                                v-model="form.role"
                                :icon="icon"
                                rounded
                                expanded
                            >
                                <option :value="null">You're a student or a teacher</option>
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                            </b-select>
                        </b-field>
                        <div class="pt-4">
                            <b-button
                                type="is-primary"
                                @click="onConfirm"
                                rounded
                                >Confirm</b-button
                            >
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            roleConfirmed: false,
            form: {
                role: null,
                name: "",
                email: "",
                password: "",
                confirm_password: ""
            },

            errors: {
                name: "",
                email: "",
                password: "",
                confirm_password: ""
            }
        };
    },
    computed: {
        icon() {
            if (this.form.role === "student") {
              return "school";
            } else if (this.form.role === "teacher") {
              return "teach";
            } else {
              return "account";
            }
        }
    },

    mounted() {
        this.check();
    },

    methods: {
        check() {
            if (this.$route.query.as) {
                switch (this.$route.query.as) {
                    case "teacher":
                        this.form.role = "teacher";
                        this.roleConfirmed = true;
                        break;

                    case "student":
                        this.form.role = "student";
                        this.roleConfirmed = true;
                        break;

                    default:
                        this.form.role = null;
                        this.roleConfirmed = false;
                        break;
                }
            }
        },

        onConfirm() {
            this.roleConfirmed = this.form.role !== null ? true : false;
        },

        inputState(s) {
            if (s.length > 0) {
                return "is-danger";
            } else {
                return "is-primary";
            }
        },

        async register() {
            this.loading = true;
            this.errors = {
                name: "",
                email: "",
                password: "",
                confirm_password: ""
            };
            const { role, name, email, password, confirm_password } = this.form;
            const allow =
                role &&
                name.length &&
                email.length &&
                password.length &&
                confirm_password.length;

            if (allow) {
                const { data } = await axios.post(API.compositeRegister, {
                    role,
                    name,
                    email,
                    password,
                    confirm_password
                });

                if ("error" in data) {
                    this.errors = {
                        ...this.errors,
                        ...data.error
                    };
                } else {
                    if (role === "teacher") {
                        this.$router.push("/teacher");
                    } else {
                        this.$router.push("/login");
                    }
                }
            }
            this.loading = false;
        }
    }
};
</script>

<style lang="scss" scoped>
.card {
    margin: auto;
    width: 450px;
    border-radius: 24px;
    padding: 46px;
}
</style>
