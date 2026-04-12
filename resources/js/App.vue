<template>
    <div>
        <router-link :to="{name: 'home'}">Accueil</router-link>
        <router-link :to="{name: 'boutique'}">Boutique</router-link>

        <panier-component></panier-component>

        <router-view></router-view>
    </div>
</template>

<script>
import PanierComponent from './components/ecom/PanierComponent.vue';

export default {
    name: "App",
    components: {
        PanierComponent
    }
};
</script>