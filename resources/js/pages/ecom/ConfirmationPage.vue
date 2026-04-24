<template>
    <div>
        <h1>
            Etape finale (confirmation)
        </h1>

        <panier-details-component :readonly="true"></panier-details-component>
        
        <button @click="storeOrder">
            Commander
        </button>
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
            axios.post('/order/checkout', { cart_id: this.cart.id })
                .then((response) => {
                    window.location.href = response.data.url;
                })
        }
    }
}
</script>