<template>
    <table v-if="cart && cart.items && cart.items.length > 0">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Prix total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in cart.items" :key="item.id">
                <td>
                    {{ item.product_variant_id ? item.product_variant.product.name : item.product.name }}

                    <section v-if="item.product_variant_id">
                        <span v-if="item.product_variant.size">{{ item.product_variant.size }}</span>

                        <span v-if="item.product_variant.color">{{ item.product_variant.color }}</span>
                        
                        <span v-if="item.product_variant.capacity">{{ item.product_variant.capacity }}</span>
                    </section>
                </td>
                

                <td>{{ item.quantity }}</td>

                <td>{{ formatPrice(item.product_variant_id ? item.product_variant.price : item.product.price) }}</td>
                <td>{{ formatPrice((item.product_variant_id ? item.product_variant.price : item.product.price) * item.quantity) }}</td>
            
                <td v-if="!readonly">
                    <button @click="add(item.product_variant_id ? item.product_variant.id : item.product.id, item.product_variant_id ? true : false)">+</button>
                    <button @click="decrement(item.product_variant_id ? item.product_variant.id : item.product.id, item.product_variant_id ? true : false)">-</button>
                    <button @click="removeItem(item.product_variant_id ? item.product_variant.id : item.product.id, item.product_variant_id ? true : false)">Supprimer</button>
                </td>
            </tr>
        </tbody>
    </table>

    <section>
        <p>Total HT - {{ formatPrice(totalHT) }}</p>
        <p>Total TTC : {{ formatPrice(totalTTC) }}</p>
        <button v-if="!readonly" @click="removeCart(cart.id)">Vider le panier</button>
    </section>
</template>

<script>
import { useCartStore } from '../../../src/stores/cartStore';
import { formatPrice } from '../../../src/helpers/format';

export default {
    name: 'PanierDetailsComponent',
    computed: {
        cart() {
            return useCartStore().cart
        },
        totalHT() {
            return useCartStore().totalHT
        },
        totalTTC() {
            return useCartStore().totalTTC
        }
    },
    props: {
        readonly: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        formatPrice,
        add(productId, isVariant) {
            const cartStore = useCartStore();
            cartStore.add(productId, isVariant);
            this.$emit('update-cart')
        },
        decrement(productId, isVariant) {
            const cartStore = useCartStore();
            cartStore.decrement(productId, isVariant);
            this.$emit('update-cart')
        },
        removeItem(productId, isVariant) {
            const cartStore = useCartStore();
            cartStore.removeItem(productId, isVariant);
            this.$emit('update-cart')
        },
        removeCart(cartId) {
            const cartStore = useCartStore();
            cartStore.removeCart(cartId);
        },
    }
}

</script>