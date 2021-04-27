/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import '../css/custom-bootstrap.css'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import FoodList from "./components/menu/FoodList";
import FoodCreateForm from "./components/admin/food/FoodCreateForm";
import CartList from "./components/cart/CartList";
import OrderCard from "./components/order/OrderCard";
import FoodEditTable from "./components/admin/food/FoodEditTable";
import FoodEditForm from "./components/admin/food/FoodEditForm";
import OrderList from "./components/admin/order/OrderList";
import NewOrderToast from "./components/admin/inc/NewOrderToast";
import OrderUpdate from "./components/inc/OrderUpdate";
import SearchList from "./components/menu/SearchList";
import SearchBar from "./components/nav/SearchBar";
import FoodCard from "./components/menu/FoodCard";
import FoodTypeEditTable from "./components/admin/food_type/FoodTypeEditTable";
import FoodTypeEditForm from "./components/admin/food_type/FoodTypeEditForm";
import FoodCategoryEditTable from "./components/admin/food_category/FoodCategoryEditTable";
import FoodCategoryEditForm from "./components/admin/food_category/FoodCategoryEditForm";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        FoodList,
        FoodCreateForm,
        CartList,
        OrderCard,
        FoodEditTable,
        FoodEditForm,
        OrderList,
        NewOrderToast,
        OrderUpdate,
        SearchList,
        SearchBar,
        FoodCard,
        FoodTypeEditTable,
        FoodTypeEditForm,
        FoodCategoryEditTable,
        FoodCategoryEditForm
    }
});
