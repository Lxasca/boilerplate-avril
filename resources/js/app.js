import './bootstrap';
import { createApp } from "vue";
import App from "./App.vue";
import { createPinia } from 'pinia';
import { createRouter, createWebHistory } from "vue-router";
import HomePage from "./pages/HomePage.vue";
import BoutiquePage from './pages/ecom/BoutiquePage.vue';
import ProduitPage from './pages/ecom/ProduitPage.vue';
import PanierPage from './pages/ecom/PanierPage.vue';

const routes = [
    { path: "/", name: 'home', component: HomePage },

    // ecom
    { path: "/boutique", name: 'boutique', component: BoutiquePage },
    { path: "/boutique/produit/:slug", name: 'boutique-produit', component: ProduitPage },
    { path: "/panier", name: 'panier', component: PanierPage },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.mount("#app");