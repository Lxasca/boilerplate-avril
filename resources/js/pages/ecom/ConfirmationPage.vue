<template>
    <div>
        <h1>
            Etape finale (confirmation)
        </h1>

        <panier-details-component :readonly="true"></panier-details-component>
        
        <router-link :to="{ name: 'panier-paiement-succes'}"
        @click="storeOrder"
        >
            Commander
        </router-link>
    </div>
</template>

<script>
import PanierDetailsComponent from '../../components/ecom/PanierDetailsComponent.vue';
import { useCartStore } from '../../../src/stores/cartStore';
import axios from 'axios';

export default {
    name: "ConfirmationPage",
    components: {
        PanierDetailsComponent
    },
    computed: {
        cart() {
            return useCartStore().cart
        }
    },
    methods: {
        storeOrder() {
            axios
            .post('/order/store', { cart_id: this.cart.id })
            .then((response) => {
                console.log('lea, ça marche <3', response.data)
            })
        }
    }
}
</script>