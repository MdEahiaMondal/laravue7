
<template>
    <v-data-table
        :headers="headers"
        :items="roles"
        sort-by="calories"
        class="elevation-1"
        style="background-color:#363636"
        :loading="loading"
        loading-text="Loading... Please wait"
    >
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-toolbar-title>My CRUD</v-toolbar-title>
                <v-divider
                    class="mx-4"
                    inset
                    vertical
                ></v-divider>
                <v-spacer></v-spacer>
                <v-dialog v-model="dialog" max-width="500px">
                    <template v-slot:activator="{ on }">
                        <v-btn color="primary" dark class="mb-2" v-on="on">New Item</v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field v-model="editedItem.name" label="Dessert name"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field v-model="editedItem.calories" label="Calories"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field v-model="editedItem.fat" label="Fat (g)"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field v-model="editedItem.carbs" label="Carbs (g)"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field v-model="editedItem.protein" label="Protein (g)"></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                            <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
        </template>
        <template v-slot:item.actions="{ item }">
            <v-icon
                small
                class="mr-2"
                @click="editItem(item)"
            >
                mdi-pencil
            </v-icon>
            <v-icon
                small
                @click="deleteItem(item)"
            >
                mdi-delete
            </v-icon>
        </template>
        <template v-slot:no-data>
            <v-btn color="primary" @click="initialize">Reset</v-btn>
        </template>
    </v-data-table>
</template>

<script>
    export default {
        data: () => ({
            dialog: false,
            loading: false,
            headers: [
                {
                    text: 'SI',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                { text: 'Name', value: 'name' },
                { text: 'Created At', value: 'created_at' },
                { text: 'Updated At', value: 'updated_at' },
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            roles: [],
            editedIndex: -1,
            editedItem: {
                si: '',
                name: '',
                created_at: 0,
                updated_at: 0,
            },
            defaultItem: {
                si: '',
                name: '',
                created_at: 0,
                updated_at: 0,
            },
        }),
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
            },
        },

        watch: {
            dialog (val) {
                val || this.close()
            },
        },

        created () {
            this.initialize()
        },

        methods: {
            initialize () {
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

                // fatch all roles
                axios.get('/api/roles')
                    .then(res => {
                        this.loading = false;
                        this.roles = res.data.roles;
                    })
                    .catch(error => {
                        this.loading = false;
                        if(error.response.status === 401)
                        {
                            localStorage.removeItem('token');
                            this.$router.push({name: 'Login'});
                        }
                    })
            },

            editItem (item) {
                this.editedIndex = this.roles.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            deleteItem (item) {
                const index = this.roles.indexOf(item)
                confirm('Are you sure you want to delete this item?') && this.roles.splice(index, 1)
            },

            close () {
                this.dialog = false
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                }, 300)
            },

            save () {
                if (this.editedIndex > -1) {
                    Object.assign(this.roles[this.editedIndex], this.editedItem)
                } else {
                    this.roles.push(this.editedItem)
                }
                this.close()
            },
        },
    }
</script>
<style scoped>

</style>