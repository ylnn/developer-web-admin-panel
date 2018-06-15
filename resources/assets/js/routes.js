import VueRouter from "vue-router";

let routes = [
    {
        path: '/',
        name: 'home',
        component: require('./views/Home')
    },
    {
        path: '/variables/index',
        name: 'variables',
        component: require('./views/variables/Variables')
    },
    {
        path: '/skills/index',
        name: 'skills',
        component: require('./views/skills/Skills')
    },
    {
        path: '/portfolios/index',
        name: 'portfolios',
        component: require('./views/portfolios/Portfolios'),
    },
    {
        path: '/portfolios/detail/:id',
        name: 'portfolios_detail',
        component: require('./views/portfolios/PortfolioDetail')
    },
    {
        path: '/articles/index',
        name: 'articles',
        component: require('./views/articles/Articles'),
    },
    {
        path: '/articles/detail/:id',
        name: 'articles_detail',
        component: require('./views/articles/ArticleDetail')
    },
    {
        path: '/images/index',
        name: 'images',
        component: require('./views/images/Images')
    }
];

export default new VueRouter({
    routes,
    linkActiveClass: "active"
});