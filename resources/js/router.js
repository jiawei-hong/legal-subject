import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

let routes = [
    {
        path:'/',
        component:require('./components/Home').default
    },
    {
        path:'/Login',
        component: require('./components/Login').default
    },
    {
        path:'/Logout',
        component: require('./components/Logout').default
    },
    {
        path:'/YearSetting',
        component: require('./components/YearSetting').default
    },
    {
        path:'/createSchoolYear',
        component: require('./components/CreateSchoolYear').default
    },
    {
        path:'/view/SchoolYear/:id',
        component: require('./components/viewSchoolYear').default
    },
    {
        path:'/view/Finish/:id',
        component: require('./components/Finish').default
    },
    {
        path:'/view/FullMarks/:id',
        component: require('./components/FullMarks').default
    },
    {
        path:'/Exam',
        component: require('./components/Exam').default
    },
    {
        path:'/Scores',
        component: require('./components/Scores').default
    },
    {
        path:'/Upload',
        component: require('./components/FileUpload').default
    },
    {
        path:'/view/scores/:id',
        component: require('./components/ViewScore').default
    },
    {
        path:'*',
        redirect:'/'
    }
];

export default new VueRouter({
    mode:'history',
    base:'/legal_subject',
    routes
});
