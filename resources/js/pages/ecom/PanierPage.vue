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

                <section v-if="returnCodePromo !== null">
                    <p v-if="returnCodePromo">
                      Code promo {{ promoCode }} appliqué. Vous bénéficiez d'une réduction de 

                      <span v-if="promoCodeType === 'fixed'">
                        {{ formatPrice(promoCodeDiscount) }}
                      </span>
                      <span v-else>
                        {{ formatPercent(promoCodeDiscount)}}
                      </span>
                    </p>
                    <p v-else>
                        Code promo invalide
                    </p>
                </section>
            </form>
        </section>

        <section>
            <router-link :to="{ name: 'panier-livraison' }">
                Livraison
            </router-link>
        </section>
    </div>
</template>

<script>
import axios from 'axios';
import { useCartStore } from '../../../src/stores/cartStore';
import PanierDetailsComponent from '../../components/ecom/PanierDetailsComponent.vue';
import { formatPercent, formatPrice } from '../../../src/helpers/format';

export default {
    name: 'PanierPage',
    components: {
        PanierDetailsComponent
    },
    data() {
        return {
            promoCode: null,
            returnCodePromo: null,
            promoCodeDiscount: null,
            promoCodeType: null,
            promoCode: ""
        }
    },
    computed: {
        cart() {
            return useCartStore().cart
        }
    },
    methods: {
        formatPercent, formatPrice,
        submitPromoCode() {
            axios.get('/cart/promoCode', { params: { promoCode: this.promoCode } })
            .then((response) => {
                this.returnCodePromo = response.data.valid;
                
                if (response.data.valid) {
                    const cartStore = useCartStore();

                    cartStore.totalHT = response.data.totalHT;
                    cartStore.totalTTC = response.data.totalTTC;

                    this.promoCodeDiscount = response.data.discount;
                    this.promoCodeType = response.data.type;
                    this.promoCode = response.data.code;
                }
            })
        }
    }
} 
</script>