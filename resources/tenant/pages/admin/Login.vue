<template>
    <section class="container pt-100">
        <div class="content__inner">
            <div class="row">
                <section id="create" class="col-md-6 offset-md-3 mb-4">
                    <div class="card">
                        <div class="card-header-title my-3">Admin Login</div>
                        <div>
                            <div class="card-content">
                                <b-field
                                    label="E-mail"
                                    :message="validator.email"
                                >
                                    <b-input
                                        name="email"
                                        type="email"
                                        icon="email"
                                        v-model="form.email"
                                        :disabled="loading"
                                    />
                                </b-field>
                                <b-field
                                    label="Password"
                                    :message="validator.password"
                                >
                                    <b-input
                                        name="password"
                                        type="password"
                                        password-reveal
                                        icon="lock"
                                        v-model="form.password"
                                        :disabled="loading"
                                    />
                                </b-field>
                                <div
                                    class="py-3 has-text-centered has-text-danger"
                                >
                                    {{ error }}
                                </div>
                                <div class="field">
                                    <b-checkbox v-model="form.remember">
                                        Remember me
                                    </b-checkbox>
                                </div>
                                <div class="mt-6">
                                  <b-button @click="login" :disabled="allowSubmit" :class="{ 'is-loading': loading }" variant="primary">Log In</b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: ["isLoggedIn"],
    data() {
        return {
            validator: {
                email: "",
                password: "",
                remember: ""
            },
            error: "",
            loading: false,
            form: {
                email: "",
                password: "",
                remember: true
            }
        };
    },
    computed: {
        allowSubmit() {
            return this.form.password.length && this.form.email.length
                ? false
                : true;
        }
    },
    methods: {
        async login() {
            this.loading = true;
            const { email, password, remember } = this.form;
            const { data } = await axios.post(API.login, {
                email,
                password,
                remember
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
                this.$buefy.snackbar.open({
                    message: "Successfully logged-in",
                    type: "is-success",
                    position: "is-top",
                    actionText: "close"
                });

                this.$router.push({ name: "AdminIndex" });
                //window.location.href = '/admin/dashboard';
            }
        }
    }
};
</script>

<style lang="scss" scoped>
.card {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
}
</style>
