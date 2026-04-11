import './bootstrap';
import { createApp } from "vue";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router";
import HomePage from "./pages/HomePage.vue";
import BoutiquePage from './pages/ecom/BoutiquePage.vue';

const routes = [
    { path: "/", name: 'home', component: HomePage },

    // ecom
    { path: "/boutique", name: 'boutique', component: BoutiquePage },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(App);
app.use(router);
app.mount("#app");