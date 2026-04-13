<template>
    <div>
        <h1>Panier</h1>

        <panier-details-component></panier-details-component>

        <!-- section saisi d'un code promo-->
        <section>
            <form @submit.prevent="submitPromoCode()">
                <div>
                    <label for="promo_code">Code promo</label>
                    <input type="text" name="promo_code" v-model="promoCode">
                </div>

                <button type="submit">
                    Appliquer
                </button>
            </form>
        </section>

        <section>
            <router-link>
                Commander
            </router-link>
        </section>
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
    data() {
        return {
            promoCode: null
        }
    },
    computed: {
        cart() {
            return useCartStore().cart
        }
    },
    methods: {
        submitPromoCode() {
            console.log('promoCode saisi : ', this.promoCode)
        }
    }
} 
</script>