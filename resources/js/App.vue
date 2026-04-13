<template>
    <div>
        <router-link :to="{name: 'home'}">Accueil</router-link>
        <router-link :to="{name: 'boutique'}">Boutique</router-link>

        <button @click="showCart">
            Panier
            <span v-if="lengthCart > 0">
                {{ lengthCart }}
            </span>
        </button>
        <panier-component :isShowCart="isShowCart"  @hide-cart="isShowCart = false"></panier-component>

        <router-view></router-view>
    </div>
</template>

<script>
import { useCartStore } from '../src/stores/cartStore';
import PanierComponent from './components/ecom/PanierComponent.vue';

export default {
    name: "App",
    data() {
        return {
            isShowCart: false
        }
    },
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
    },
    methods: {
        showCart() {
            if (this.lengthCart > 0) {
                this.isShowCart = !this.isShowCart
            } else {
                this.isShowCart = false;
            }
        }
    }
};
</script>

<style>
button {
    cursor: pointer;
}
</style>