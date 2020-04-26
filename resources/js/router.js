import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);// external pakege use like this

import LoginComponent from "./components/LoginComponent";
import AdminComponent from "./components/AdminComponent";
import RolesComponent from "./components/RolesComponent";

const routes = [
    {path: '/', redirect: {path: '/login'}},
    {path: '/login', component: LoginComponent, name: 'Login'},
    {
        path: '/admin',
        component: AdminComponent,
        name: 'Admin',
        children:[
            {
                path: 'roles',
                component: RolesComponent,
                name: 'Roles'
            }
        ],
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem('token'))
            {
                next();
            }else{
                next({name: 'Login'});
            }
        }
    },
];
export default new VueRouter({routes})

