import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);// external pakege use like this

const Foo = {template: '<v-alert type="error">Show error</v-alert>'};
const Bar = {template: '<v-alert type="success">Show success</v-alert>'};
const User = {template: '<v-alert type="info">My Name is {{ $route.params.name }}</v-alert>'};

const routes = [
    {path: '/foo', component: Foo},
    {path: '/bar', component: Bar},
    {path: '/user/:name', component: User}
];
export default new VueRouter({routes})
