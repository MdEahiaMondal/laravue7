<template>
    <v-app id="inspire">
        <v-content>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-12">
                            <v-toolbar color="error" dark flat>
                                <v-toolbar-title>Login form</v-toolbar-title>
                                <v-spacer />
                            </v-toolbar>
                            <v-card-text>
                                <v-progress-linear
                                    :active="loading"
                                    :indeterminate="loading"
                                    absolute
                                    top
                                    color="white"
                                ></v-progress-linear>
                                <v-form ref="form"
                                        v-model="valid"
                                >
                                    <v-text-field color="error" :rules="usernameRules" required label="Login" v-model="username" name="login" prepend-icon="mdi-account-circle-outline" type="text"/>
                                    <v-text-field  color="error" :rules="passwordRules" id="password" v-model="password" label="Password" name="password" prepend-icon="mdi-account-lock-outline" type="password"/>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn color="error" block @click="login" :disabled="!valid">Login</v-btn>
                            </v-card-actions>
                        </v-card>

                        <v-snackbar
                            v-model="snackbar"
                        >
                            {{ sanack_text }}
                            <v-btn
                                color="pink"
                                text
                                @click="snackbar = false"
                            >
                                Close
                            </v-btn>
                        </v-snackbar>

                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        name: "LoginComponent",
        data()
        {
          return {
              valid: true,
              usernameRules: [
                  v => !!v || 'Username is required',
              ],
              passwordRules: [
                  v => !!v || 'Password is required',
              ],
              username: '',
              password: '',
              loading: false,
              sanack_text: '',
              snackbar: false,
          }
        },
        created(){
            this.$vuetify.theme.dark = true
        },
        methods: {
            login()
            {
                // Add a request interceptor
                axios.interceptors.request.use((config) => {
                    // Do something before request is sent
                    this.loading = true;
                    return config;
                }, (error) => {
                    // Do something with request erro
                    this.loading = false;
                    return Promise.reject(error);
                });

                // Add a response interceptor
                axios.interceptors.response.use( (response) =>{
                    // Any status code that lie within the range of 2xx cause this function to trigger
                    // Do something with response data
                    this.loading = false;
                    return response;
                }, (error) =>{
                    // Any status codes that falls outside the range of 2xx cause this function to trigger
                    // Do something with response error
                    this.loading = false;
                    return Promise.reject(error);
                });
                axios.post('/api/login', {'username': this.username, 'password': this.password})
                    .then(res => {
                        this.loading = false;
                        localStorage.setItem('token', res.data.token) // take token in session
                        this.$router.push('/admin') // then redirect to others pages
                            .then(res => {
                                console.log('Login Successfully')
                            })
                            .catch(error => {
                                console.log(error)
                            });
                        localStorage.setItem('loggedIn', true)
                    })
                    .catch(error => {
                        this.snackbar = true;
                        this.sanack_text = error.response.data.status
                    })
                // localStorage.setItem('token', '65df42s3dfs5d4f')
            }
        }
    }
</script>

<style scoped>

</style>
