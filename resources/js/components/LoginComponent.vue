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
                                <v-form>
                                    <v-text-field label="Login" v-model="username" name="login" prepend-icon="mdi-account-circle-outline" type="text"/>
                                    <v-text-field id="password" v-model="password" label="Password" name="password" prepend-icon="mdi-account-lock-outline" type="password"/>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn color="error" block @click="login">Login</v-btn>
                            </v-card-actions>
                        </v-card>
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
              username: '',
              password: ''
          }
        },
        methods: {
            login()
            {
                localStorage.setItem('token', '65df42s3dfs5d4f')
            }
        }
    }
</script>

<style scoped>

</style>
