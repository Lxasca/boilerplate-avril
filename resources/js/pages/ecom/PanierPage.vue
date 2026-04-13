<template>
    <div>
        <h1>Panier</h1>

         <panier-details-component></panier-details-component>
    </div>
</template>

<script>
import { useCartStore } from '../../../src/stores/cartStore';
import PanierDetailsComponent from '../../components/ecom/PanierDetailsComponent.vue';

export default {
    name: 'PanierPage',
    components: {
        PanierDetailsComponent
    },
    computed: {
        cart() {
            return useCartStore().cart
        }
    }
} 
</script>