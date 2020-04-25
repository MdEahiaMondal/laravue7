<template>
    <div>
        <v-container>
            <v-alert type="info" >I am Here </v-alert>
        </v-container>
        <v-content>
            <v-btn link to="/foo">Foo</v-btn>
            <v-btn link to="/bar">Bar</v-btn>
            <v-btn link to="/user/khan">User With params</v-btn>
            <router-view></router-view>
        </v-content>
    </div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
