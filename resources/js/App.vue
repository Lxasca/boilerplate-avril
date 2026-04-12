<template>
    <div>
        <router-link :to="{name: 'home'}">Accueil</router-link>
        <router-link :to="{name: 'boutique'}">Boutique</router-link>

        <button>
            Panier
            <span v-if="lengthCart > 0">
                {{ lengthCart }}
            </span>
        </button>
        <panier-component></panier-component>

        <router-view></router-view>
    </div>
</template>

<script>
import { useCartStore } from '../src/stores/cartStore';
import PanierComponent from './components/ecom/PanierComponent.vue';

export default {
    name: "App",
    components: {
        PanierComponent
    },
    mounted() {
        useCartStore().getCart()
    },
    computed: {
        lengthCart() {
            return useCartStore().cart?.items?.reduce((total, item) => total + item.quantity, 0) ?? 0
        }
    }
};
</script>