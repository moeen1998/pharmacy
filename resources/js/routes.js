import Home from './components/home/index.vue';
import User from './components/users/index.vue';
import UserCreate from './components/users/create.vue';
import UserEdit from './components/users/edit.vue';

import supplier from './components/supplier/index.vue';
import supplierCreate from './components/supplier/create.vue';
import supplierEdit from './components/supplier/edit.vue';

import ranks from './components/rancks/index.vue';
import ranksCreate from './components/rancks/create.vue';
import ranksEdit from './components/rancks/edit.vue';

import drugs from './components/mediciens/index.vue';
import drugsCreate from './components/mediciens/create.vue';
import drugsEdit from './components/mediciens/edit.vue';

import companies from './components/company/index.vue';
import companyCreate from './components/company/create.vue';
import companyEdit from './components/company/edit.vue';

import categories from './components/categories/index.vue';
import categoryCreate from './components/categories/create.vue';
import categoryEdit from './components/categories/edit.vue';

import parchase from './components/parchases/index.vue';
import parchaseCreate from './components/parchases/create.vue';
import parchaseEdit from './components/parchases/edit.vue';

import order from './components/orders/index.vue';
import orderCreate from './components/orders/create.vue';
import orderEdit from './components/orders/edit.vue';

export const routes = [
    {
        path: '/NewPh/public/home',
        component: Home,
        name: "PharmacyHome"
    },
    {
        path: '/NewPh/public/',
        component: Home,
        name: "Usershome"
    },

    {
        path: '/NewPh/public/user',
        component: User,
        name: "Users"
    },
    {
        path: '/NewPh/public/user/create',
        component: UserCreate,
        name: "UserCreate"
    },
    {
        path: '/NewPh/public/user/edit/:id',
        component: UserEdit,
        name: "UserEdit"
    },
    
    {
        path: '/NewPh/public/supplier',
        component: supplier,
        name: "supplier"
    },
    {
        path: '/NewPh/public/supplier/create',
        component: supplierCreate,
        name: "supplierCreate"
    },
    {
        path: '/NewPh/public/supplier/edit/:id',
        component: supplierEdit,
        name: "supplierEdit"
    },


    {
        path: '/NewPh/public/place',
        component: ranks,
        name: "place"
    },
    {
        path: '/NewPh/public/place/create',
        component: ranksCreate,
        name: "placeCreate"
    },
    {
        path: '/NewPh/public/place/edit/:id',
        component: ranksEdit,
        name: "placeEdit"
    },

    {
        path: '/NewPh/public/drug',
        component: drugs,
        name: "drug"
    },
    {
        path: '/NewPh/public/drug/create',
        component: drugsCreate,
        name: "drugCreate"
    },
    {
        path: '/NewPh/public/drug/edit/:id',
        component: drugsEdit,
        name: "drugEdit"
    },

    {
        path: '/NewPh/public/company',
        component: companies,
        name: "company"
    },
    {
        path: '/NewPh/public/company/create',
        component: companyCreate,
        name: "companyCreate"
    },
    {
        path: '/NewPh/public/company/edit/:id',
        component: companyEdit,
        name: "companyEdit"
    },

    {
        path: '/NewPh/public/category',
        component: categories,
        name: "category"
    },
    {
        path: '/NewPh/public/category/create',
        component: categoryCreate,
        name: "categoryCreate"
    },
    {
        path: '/NewPh/public/category/edit/:id',
        component: categoryEdit,
        name: "categoryEdit"
    },

    {
        path: '/NewPh/public/order',
        component: order,
        name: "order"
    },
    {
        path: '/NewPh/public/order/create',
        component: orderCreate,
        name: "orderCreate"
    },
    {
        path: '/NewPh/public/order/edit/:id',
        component: orderEdit,
        name: "orderEdit"
    },

    {
        path: '/NewPh/public/parchase',
        component: parchase,
        name: "parchase"
    },
    {
        path: '/NewPh/public/parchase/create',
        component: parchaseCreate,
        name: "parchaseCreate"
    },
    {
        path: '/NewPh/public/parchase/edit/:id',
        component: parchaseEdit,
        name: "parchaseEdit"
    },
];