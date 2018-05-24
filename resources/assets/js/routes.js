import VueRouter from "vue-router";

let routes = [
    {
        path: '/',
        component: require('./views/Home')
    },
    {
        path: '/variables/index',
        component: require('./views/variables/Variables')
    },
    {
        path: '/portfolios/index',
        component: require('./views/portfolios/Portfolios')
    }
];

export default new VueRouter({
    routes,
    linkActiveClass: "active"
});