import VueRouter from "vue-router";

let routes = [
    {
        path: '/',
        component: require('./views/Home')
    },
    {
        path: '/about',
        component: require('./views/About')
    },
    {
        path: '/variables/index',
        component: require('./views/variables/Index')
    }
];

export default new VueRouter({
    routes,
    linkActiveClass: "active"
});